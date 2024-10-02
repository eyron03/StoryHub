<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User  as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Parents extends Authenticatable implements CanResetPassword
{
    use Notifiable;
    protected $guarded =[];
    use HasFactory;

    public function children()
    {
        return $this->hasMany(Children::class, 'parent_id', 'id');
    }
    public function teacher()
    {
        return $this->belongsTo(Teachers::class, 'teachers_id');
    }
}
