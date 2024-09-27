<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PasswordResetModel extends Model
{
    use SoftDeletes;

    protected $table = 'password_reset';

    protected $fillable = ['email',
        'token',
    ];
}
