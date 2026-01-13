<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeyAuth extends Model
{
    use HasFactory;

    protected $table = 'keyauth';

    protected $fillable = [
        'name',
        'email',
        'login_key',
    ];
}
