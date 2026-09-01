<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class KeyAuth extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'keyauth';

    protected $fillable = [
        'name',
        'email',
        'login_key',
        'password',
        'email_verified_at',
        'remember_token',
        'profile_pic',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
    ];

    protected $hidden = [
        'login_key',
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'two_factor_confirmed_at' => 'datetime',
        'password' => 'hashed',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function loginHistories()
    {
        return $this->hasMany(LoginHistory::class, 'keyauth_id');
    }

    public function sessions()
    {
        return $this->hasMany(KeyAuthSession::class, 'keyauth_id');
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class, 'keyauth_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Login Key
    |--------------------------------------------------------------------------
    */

    public function setLoginKeyAttribute($value)
    {
        if ($value !== null && $value !== '') {
            $this->attributes['login_key'] = hash_hmac(
                'sha256',
                $value,
                config('app.key')
            );
        }
    }

    public function getPlainLoginKey()
    {
        return null;
    }

    public static function findByLoginKey(string $key)
    {
        return static::where(
            'login_key',
            hash_hmac('sha256', $key, config('app.key'))
        )->first();
    }

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        if (!is_null($value)) {
            $this->remember_token = $value;
        }
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /*
    |--------------------------------------------------------------------------
    | Email Verification
    |--------------------------------------------------------------------------
    */

    public function hasVerifiedEmail()
    {
        return !is_null($this->email_verified_at);
    }

    public function markEmailAsVerified()
    {
        $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /*
    |--------------------------------------------------------------------------
    | Two Factor Authentication
    |--------------------------------------------------------------------------
    */

    public function hasConfirmedTwoFactor()
    {
        return !is_null($this->two_factor_confirmed_at);
    }

    public function confirmTwoFactor()
    {
        $this->forceFill([
            'two_factor_confirmed_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function generateTwoFactorSecret()
    {
        $secret = base64_encode(random_bytes(16));

        $this->forceFill([
            'two_factor_secret' => encrypt($secret),
        ])->save();

        return $secret;
    }

    public function getTwoFactorSecret()
    {
        if (!$this->two_factor_secret) {
            return null;
        }

        return decrypt($this->two_factor_secret);
    }

    public function getTwoFactorQrCodeUrl(string $secret): string
    {
        $issuer = urlencode(
            config('app.name', 'Key Auth System')
        );

        $account = urlencode($this->email);

        $rawSecret = base64_decode($secret, true);

        $base32Secret = $this->base32Encode($rawSecret);

        return 'otpauth://totp/'
            . $issuer
            . ':'
            . $account
            . '?secret='
            . $base32Secret
            . '&issuer='
            . $issuer
            . '&algorithm=SHA1&digits=6&period=30';
    }

    private function base32Encode(string $data): string
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';

        $binary = '';

        foreach (str_split($data) as $char) {
            $binary .= sprintf(
                '%08b',
                ord($char)
            );
        }

        $result = '';

        for ($i = 0; $i < strlen($binary); $i += 5) {

            $chunk = substr(
                $binary,
                $i,
                5
            );

            $chunk = str_pad(
                $chunk,
                5,
                '0'
            );

            $result .= $alphabet[
                bindec($chunk)
            ];
        }

        return $result;
    }
}