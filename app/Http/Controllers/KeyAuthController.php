<?php

namespace App\Http\Controllers;

use App\Models\KeyAuth;
use App\Models\KeyAuthSession;
use App\Models\LoginHistory;
use App\Models\AuditLog;
use App\Models\KeyAuthPasswordResetToken;
use App\Notifications\LoginAlert;
use App\Notifications\ResetLoginKey;
use App\Notifications\VerifyEmail;
use App\Notifications\WelcomeEmail;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class KeyAuthController extends Controller
{
    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:keyauth,email',
            'login_key'  => 'required|string|min:4|max:255',
            'password'   => 'nullable|string|min:6|confirmed',
        ]);

        $user = KeyAuth::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'login_key'  => $request->login_key,
            'password'   => $request->password ? Hash::make($request->password) : null,
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addHours(24),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        AuditLog::create([
            'keyauth_id'    => $user->id,
            'event'         => 'registered',
            'auditable_type' => KeyAuth::class,
            'auditable_id'  => $user->id,
            'new_values'    => $user->toArray(),
            'ip_address'    => $request->ip(),
            'user_agent'    => $request->userAgent(),
            'url'           => $request->fullUrl(),
        ]);

        $user->notify(new VerifyEmail());
        $user->notify(new WelcomeEmail($user));

        Session::put('verification_url', $verificationUrl);

        return redirect()->route('login.form')
            ->with('success', 'Registration successful! Please verify your email.');
    }

    public function loginForm(Request $request)
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'key'    => 'required|string',
            'password' => 'nullable|string',
            'remember' => 'nullable|boolean',
        ]);

        $key = $request->key;

        if ($request->filled('password')) {
            $user = KeyAuth::where('email', $key)->orWhere('login_key', hash_hmac('sha256', $key, config('app.key')))->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                $this->recordLoginHistory($user?->id, $request, 'failed');
                return back()->with('error', 'Invalid credentials!')->withInput();
            }
        } else {
            $user = KeyAuth::findByLoginKey($key);
            if (!$user) {
                $this->recordLoginHistory(null, $request, 'failed');
                return back()->with('error', 'Invalid Login Key!')->withInput();
            }
        }

        if (!$user->hasVerifiedEmail()) {
            return back()->with('error', 'Please verify your email before logging in.')->withInput();
        }

        $this->recordLoginHistory($user->id, $request, 'success');

        Session::put('keyauth_user', $user->id);

        if ($user->hasConfirmedTwoFactor()) {
            Session::put('2fa_user_id', $user->id);
            Session::put('2fa_remember', $request->filled('remember'));
            return redirect()->route('2fa.form');
        }

        if ($request->filled('remember')) {
            $token = Str::random(60);
            $user->forceFill([
                'remember_token' => $token,
            ])->save();
            Cookie::queue('keyauth_remember', $token, 60 * 24 * 30);
        }

        Session::put('2fa_passed', true);

        $this->createSessionRecord($user, $request);

        $user->notify(new LoginAlert($request->ip(), $this->getBrowser($request->userAgent()), 'Unknown'));

        AuditLog::create([
            'keyauth_id'    => $user->id,
            'event'         => 'login',
            'auditable_type' => KeyAuth::class,
            'auditable_id'  => $user->id,
            'ip_address'    => $request->ip(),
            'user_agent'    => $request->userAgent(),
            'url'           => $request->fullUrl(),
        ]);

        return redirect()->route('dashboard');
    }

    public function verify2fa(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $userId = Session::get('2fa_user_id');
        $user = KeyAuth::find($userId);

        if (!$user) {
            return redirect()->route('login.form')->with('error', 'Session expired. Please login again.');
        }

        $secret = decrypt($user->two_factor_secret);
        $code = $request->code;

        if (!$this->verifyTOTP($secret, $code)) {
            return back()->with('error', 'Invalid 2FA code!')->withInput();
        }

        Session::put('2fa_passed', true);
        Session::forget('2fa_user_id');

        if ($request->session()->has('2fa_remember')) {
            $token = Str::random(60);
            $user->forceFill(['remember_token' => $token])->save();
            Cookie::queue('keyauth_remember', $token, 60 * 24 * 30);
        }

        $this->createSessionRecord($user, $request);

        AuditLog::create([
            'keyauth_id'    => $user->id,
            'event'         => '2fa_verified',
            'auditable_type' => KeyAuth::class,
            'auditable_id'  => $user->id,
            'ip_address'    => $request->ip(),
            'user_agent'    => $request->userAgent(),
            'url'           => $request->fullUrl(),
        ]);

        return redirect()->route('dashboard');
    }

    public function twoFactorForm()
    {
        if (!Session::has('2fa_user_id')) {
            return redirect()->route('login.form');
        }
        return view('auth.2fa');
    }

    public function dashboard(Request $request)
    {
        $userId = Session::get('keyauth_user');
        $user = KeyAuth::find($userId);

        if (!$user) {
            Session::forget('keyauth_user');
            return redirect()->route('login.form');
        }

        $stats = [
            'total_users' => KeyAuth::count(),
            'verified_users' => KeyAuth::whereNotNull('email_verified_at')->count(),
            'today_logins' => LoginHistory::whereDate('login_at', today())->count(),
            'failed_logins_today' => LoginHistory::whereDate('login_at', today())->where('status', 'failed')->count(),
        ];

        $recentLogins = LoginHistory::where('keyauth_id', $user->id)
            ->latest('login_at')
            ->limit(10)
            ->get();

        $recentLoginsChart = LoginHistory::selectRaw('DATE(login_at) as date, COUNT(*) as count')
            ->where('keyauth_id', $user->id)
            ->where('login_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $userSessions = KeyAuthSession::where('keyauth_id', $user->id)
            ->orderByDesc('last_activity')
            ->get();

        return view('dashboard', compact('user', 'stats', 'recentLogins', 'recentLoginsChart', 'userSessions'));
    }

    public function logout(Request $request)
    {
        $userId = Session::get('keyauth_user');

        if ($userId) {
            LoginHistory::where('keyauth_id', $userId)
                ->whereNull('logout_at')
                ->where('status', 'success')
                ->latest('login_at')
                ->first()?->update(['logout_at' => now()]);

            KeyAuthSession::where('keyauth_id', $userId)
                ->where('session_id', Session::getId())
                ->delete();

            AuditLog::create([
                'keyauth_id'    => $userId,
                'event'         => 'logout',
                'auditable_type' => KeyAuth::class,
                'auditable_id'  => $userId,
                'ip_address'    => $request->ip(),
                'user_agent'    => $request->userAgent(),
                'url'           => $request->fullUrl(),
            ]);
        }

        Session::forget('keyauth_user');
        Session::forget('2fa_passed');
        Session::forget('2fa_user_id');
        Cookie::queue(Cookie::forget('keyauth_remember'));

        return redirect()->route('login.form')->with('success', 'Logged out successfully!');
    }

    public function logoutAllDevices(Request $request)
    {
        $userId = Session::get('keyauth_user');
        $user = KeyAuth::find($userId);

        if ($user) {
            KeyAuthSession::where('keyauth_id', $user->id)->delete();
            $user->forceFill(['remember_token' => null])->save();
            Cookie::queue(Cookie::forget('keyauth_remember'));

            AuditLog::create([
                'keyauth_id'    => $user->id,
                'event'         => 'logout_all_devices',
                'auditable_type' => KeyAuth::class,
                'auditable_id'  => $user->id,
                'ip_address'    => $request->ip(),
                'user_agent'    => $request->userAgent(),
                'url'           => $request->fullUrl(),
            ]);
        }

        return back()->with('success', 'Logged out from all devices successfully!');
    }

    public function profileForm()
    {
        $user = KeyAuth::find(Session::get('keyauth_user'));
        return view('profile.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = KeyAuth::find(Session::get('keyauth_user'));

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:keyauth,email,' . $user->id,
            'profile_pic' => 'nullable|image|max:2048',
        ]);

        $oldValues = $user->toArray();

        if ($request->hasFile('profile_pic')) {
            $path = $request->file('profile_pic')->store('profile_pics', 'public');
            $user->profile_pic = $path;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        AuditLog::create([
            'keyauth_id'    => $user->id,
            'event'         => 'profile_updated',
            'auditable_type' => KeyAuth::class,
            'auditable_id'  => $user->id,
            'old_values'    => $oldValues,
            'new_values'    => $user->fresh()->toArray(),
            'ip_address'    => $request->ip(),
            'user_agent'    => $request->userAgent(),
            'url'           => $request->fullUrl(),
        ]);

        return back()->with('success', 'Profile updated successfully!');
    }

    public function forgotKeyForm()
    {
        return view('auth.forgot-key');
    }

    public function sendResetKeyLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = KeyAuth::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'No account found with this email.');
        }

        $token = Str::random(60);

        KeyAuthPasswordResetToken::create([
            'email' => $user->email,
            'token' => Hash::make($token),
        ]);

        $user->notify(new ResetLoginKey($token));

        $resetUrl = URL::temporarySignedRoute(
            'reset.key.form',
            now()->addHours(1),
            ['token' => $token]
        );

        return back()->with('success', 'Reset link sent to your email!');
    }

    public function resetKeyForm(Request $request, $token)
    {
        $resetRecord = KeyAuthPasswordResetToken::where('email', $request->email)->first();

        if (!$resetRecord || !Hash::check($token, $resetRecord->token)) {
            return redirect()->route('login.form')->with('error', 'Invalid or expired reset token.');
        }

        $user = KeyAuth::where('email', $request->email)->first();

        return view('auth.reset-key', compact('user', 'token'));
    }

    public function resetKey(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'login_key' => 'required|string|min:4|max:255',
        ]);

        $resetRecord = KeyAuthPasswordResetToken::where('email', $request->email)->first();

        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            return back()->with('error', 'Invalid or expired reset token.');
        }

        $user = KeyAuth::where('email', $request->email)->first();
        $oldKey = $user->login_key;

        $user->login_key = $request->login_key;
        $user->save();

        $resetRecord->delete();

        AuditLog::create([
            'keyauth_id'    => $user->id,
            'event'         => 'login_key_reset',
            'auditable_type' => KeyAuth::class,
            'auditable_id'  => $user->id,
            'old_values'    => ['login_key' => $oldKey],
            'new_values'    => ['login_key' => $request->login_key],
            'ip_address'    => $request->ip(),
            'user_agent'    => $request->userAgent(),
            'url'           => $request->fullUrl(),
        ]);

        return redirect()->route('login.form')->with('success', 'Login key reset successfully!');
    }

    public function verifyEmail($id, $hash)
    {
        $user = KeyAuth::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($user->email))) {
            return redirect()->route('login.form')->with('error', 'Invalid verification link.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('dashboard')->with('success', 'Email already verified!');
        }

        $user->markEmailAsVerified();

        AuditLog::create([
            'keyauth_id'    => $user->id,
            'event'         => 'email_verified',
            'auditable_type' => KeyAuth::class,
            'auditable_id'  => $user->id,
            'ip_address'    => request()->ip(),
            'user_agent'    => request()->userAgent(),
            'url'           => request()->fullUrl(),
        ]);

        return redirect()->route('login.form')->with('success', 'Email verified successfully! You can now login.');
    }

    public function resendVerification(Request $request)
    {
        $user = KeyAuth::find(Session::get('keyauth_user'));

        if (!$user) {
            return redirect()->route('login.form');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('dashboard')->with('success', 'Email already verified!');
        }

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addHours(24),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        return back()->with('success', 'Verification link: ' . $verificationUrl);
    }

    public function securityForm()
    {
        $user = KeyAuth::find(Session::get('keyauth_user'));
        return view('profile.security', compact('user'));
    }

    public function toggleTwoFactor(Request $request)
    {
        $user = KeyAuth::find(Session::get('keyauth_user'));

        if ($request->has('two_factor_enabled')) {
            if (!$user->two_factor_secret) {
                $secret = $user->generateTwoFactorSecret();
                Session::put('2fa_setup_secret', $secret);

                AuditLog::create([
                    'keyauth_id'    => $user->id,
                    'event'         => '2fa_setup_initiated',
                    'auditable_type' => KeyAuth::class,
                    'auditable_id'  => $user->id,
                    'ip_address'    => $request->ip(),
                    'user_agent'    => $request->userAgent(),
                    'url'           => $request->fullUrl(),
                ]);

                return redirect()->route('2fa.setup');
            }

            $user->confirmTwoFactor();
            Session::forget('2fa_setup_secret');

            AuditLog::create([
                'keyauth_id'    => $user->id,
                'event'         => '2fa_enabled',
                'auditable_type' => KeyAuth::class,
                'auditable_id'  => $user->id,
                'ip_address'    => $request->ip(),
                'user_agent'    => $request->userAgent(),
                'url'           => $request->fullUrl(),
            ]);

            return back()->with('success', 'Two-Factor Authentication enabled!');
        } else {
            $user->forceFill([
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
            ])->save();

            Session::forget('2fa_setup_secret');

            AuditLog::create([
                'keyauth_id'    => $user->id,
                'event'         => '2fa_disabled',
                'auditable_type' => KeyAuth::class,
                'auditable_id'  => $user->id,
                'ip_address'    => $request->ip(),
                'user_agent'    => $request->userAgent(),
                'url'           => $request->fullUrl(),
            ]);

            return back()->with('success', 'Two-Factor Authentication disabled!');
        }
    }

    public function twoFactorSetup()
    {
        $user = KeyAuth::find(Session::get('keyauth_user'));
        $secret = Session::get('2fa_setup_secret');

        if (!$user || !$secret) {
            return redirect()->route('profile.security');
        }

        $qrCodeUrl = $user->getTwoFactorQrCodeUrl($secret);

        try {
            $qrCode = new QrCode(
                data: $qrCodeUrl,
                size: 200,
                margin: 10,
            );

            $writer = new SvgWriter();
            $result = $writer->write($qrCode);
            $qrCodeSvg = 'data:image/svg+xml;base64,' . base64_encode($result->getString());
        } catch (\Exception $e) {
            $qrCodeSvg = null;
        }

        return view('profile.2fa-setup', compact('user', 'secret', 'qrCodeUrl', 'qrCodeSvg'));
    }

    public function confirmTwoFactorSetup(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $user = KeyAuth::find(Session::get('keyauth_user'));
        $secret = Session::get('2fa_setup_secret');

        if (!$user || !$secret) {
            return redirect()->route('profile.security');
        }

        if (!$this->verifyTOTP($secret, $request->code)) {
            return back()->with('error', 'Invalid verification code!')->withInput();
        }

        $user->confirmTwoFactor();
        Session::forget('2fa_setup_secret');

        AuditLog::create([
            'keyauth_id'    => $user->id,
            'event'         => '2fa_enabled',
            'auditable_type' => KeyAuth::class,
            'auditable_id'  => $user->id,
            'ip_address'    => $request->ip(),
            'user_agent'    => $request->userAgent(),
            'url'           => $request->fullUrl(),
        ]);

        return redirect()->route('profile.security')->with('success', 'Two-Factor Authentication has been enabled successfully!');
    }

    public function updatePassword(Request $request)
    {
        $user = KeyAuth::find(Session::get('keyauth_user'));

        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();

        AuditLog::create([
            'keyauth_id'    => $user->id,
            'event'         => 'password_updated',
            'auditable_type' => KeyAuth::class,
            'auditable_id'  => $user->id,
            'ip_address'    => $request->ip(),
            'user_agent'    => $request->userAgent(),
            'url'           => $request->fullUrl(),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }

    public function sessionsList()
    {
        $user = KeyAuth::find(Session::get('keyauth_user'));
        $sessions = KeyAuthSession::where('keyauth_id', $user->id)
            ->orderByDesc('last_activity')
            ->get();

        return view('profile.sessions', compact('sessions'));
    }

    public function usersList(Request $request)
    {
        $query = KeyAuth::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->orderByDesc('created_at')->paginate(10)->appends($request->query());

        return view('users.index', compact('users'));
    }

    public function getLoginKey(Request $request)
    {
        $user = KeyAuth::where('email', $request->email)->first();

        if ($user) {
            return response()->json([
                'status' => true,
                'key' => '****',
            ]);
        }

        return response()->json([
            'status' => false
        ]);
    }

    protected function recordLoginHistory(?int $userId, Request $request, string $status): void
    {
        LoginHistory::create([
            'keyauth_id'    => $userId,
            'ip_address'    => $request->ip(),
            'user_agent'    => $request->userAgent(),
            'device_type'   => $this->getDeviceType($request->userAgent()),
            'browser'       => $this->getBrowser($request->userAgent()),
            'platform'      => $this->getPlatform($request->userAgent()),
            'status'        => $status,
            'login_at'      => now(),
        ]);
    }

    protected function createSessionRecord(KeyAuth $user, Request $request): void
    {
        KeyAuthSession::updateOrCreate(
            ['session_id' => Session::getId()],
            [
                'keyauth_id'    => $user->id,
                'ip_address'    => $request->ip(),
                'user_agent'    => $request->userAgent(),
                'device_type'   => $this->getDeviceType($request->userAgent()),
                'last_activity' => now(),
                'is_current'    => true,
            ]
        );
    }

    protected function verifyTOTP(string $secret, string $code): bool
    {
        $timeSlice = floor(time() / 30);
        $secretKey = base64_decode($secret, true);

        for ($i = -1; $i <= 1; $i++) {
            $hash = hash_hmac('sha1', pack('N', $timeSlice + $i), $secretKey);
            $offset = ord($hash[19]) & 0x0F;
            $truncatedHash = unpack('N', substr($hash, $offset, 4))[1] & 0x7FFFFFFF;
            $otp = str_pad($truncatedHash % 1000000, 6, '0', STR_PAD_LEFT);

            if (hash_equals($otp, $code)) {
                return true;
            }
        }

        return false;
    }

    protected function getDeviceType(?string $userAgent): ?string
    {
        if (!$userAgent) return 'desktop';

        if (stripos($userAgent, 'mobile') !== false) return 'mobile';
        if (stripos($userAgent, 'tablet') !== false) return 'tablet';
        return 'desktop';
    }

    protected function getBrowser(?string $userAgent): ?string
    {
        if (!$userAgent) return 'Unknown';

        if (stripos($userAgent, 'Edg') !== false) return 'Edge';
        if (stripos($userAgent, 'Chrome') !== false) return 'Chrome';
        if (stripos($userAgent, 'Safari') !== false) return 'Safari';
        if (stripos($userAgent, 'Firefox') !== false) return 'Firefox';
        return 'Unknown';
    }

    protected function getPlatform(?string $userAgent): ?string
    {
        if (!$userAgent) return 'Unknown';

        if (stripos($userAgent, 'Windows') !== false) return 'Windows';
        if (stripos($userAgent, 'Mac') !== false) return 'macOS';
        if (stripos($userAgent, 'Linux') !== false) return 'Linux';
        if (stripos($userAgent, 'Android') !== false) return 'Android';
        if (stripos($userAgent, 'iOS') !== false) return 'iOS';
        return 'Unknown';
    }
}
