<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KeyAuthSession extends Model
{
    protected $table = 'keyauth_sessions';

    protected $fillable = [
        'keyauth_id',
        'session_id',
        'ip_address',
        'user_agent',
        'device_type',
        'last_activity',
        'expires_at',
        'is_current',
    ];

    protected $casts = [
        'last_activity' => 'datetime',
        'expires_at' => 'datetime',
        'is_current' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(KeyAuth::class, 'keyauth_id');
    }
}
