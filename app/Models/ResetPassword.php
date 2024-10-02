<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResetPassword extends Model
{
    use HasFactory;
    protected $fillable = [
        'email', 'token',
    ];

    // The attributes that should be hidden for arrays.
    protected $hidden = [];
}
