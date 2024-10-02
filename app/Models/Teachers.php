<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User  as Authenticatable;

class Teachers extends Authenticatable implements CanResetPassword
{
    use Notifiable;
    use HasFactory;
    protected $guarded =[];
    public function parents()
    {
        return $this->hasMany(Parent::class, 'teachers_id');
    }
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function quizResults()
    {
        return $this->hasMany(QuizResult::class); 
    }
    public function gradeLevel()
    {
        return $this->hasOne(GradeLevel::class, 'teacher_id');
    }
}
