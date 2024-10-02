<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User  as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Quiz extends  Authenticatable
{
    use Notifiable;
    protected $guarded =[];
    use HasFactory;
    public function flipbook()
    {
        return $this->belongsTo(Flipbook::class, 'flipbook_id', 'id');
    }
    public function quizResults()
    {
        return $this->hasMany(QuizResult::class);
    }
}
