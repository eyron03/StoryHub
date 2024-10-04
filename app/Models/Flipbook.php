<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User  as Authenticatable;
class Flipbook extends Authenticatable
{
    use HasFactory;
    protected $fillable = ['book_name', 'desc', 'images','book_type'];


    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function quizResults()
    {
        return $this->hasMany(QuizResult::class); 
    }
}
