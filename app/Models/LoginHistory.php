<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoginHistory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'keyauth_id',
        'attempted_identifier',
        'ip_address',
        'user_agent',
        'device_type',
        'browser',
        'platform',
        'location',
        'status',
        'login_at',
        'logout_at',
    ];

    protected $casts = [
        'login_at' => 'datetime',
        'logout_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(KeyAuth::class, 'keyauth_id');
    }
}
