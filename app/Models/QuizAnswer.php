<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    use HasFactory;
    protected $guarded =[];

    // Define relationships (optional)
    public function quizResult()
    {
        return $this->belongsTo(QuizResult::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
