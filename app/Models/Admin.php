<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User  as Authenticatable;
use Illuminate\Support\Facades\Log;
class Admin extends Authenticatable implements CanResetPassword
{
    
        protected $guarded =[];
    use HasFactory;
    

}
