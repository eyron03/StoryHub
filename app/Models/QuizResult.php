<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    use HasFactory;
    protected $table = 'quiz_results';
    protected $guarded = [];
    public function child()
    {
        return $this->belongsTo(Children::class,'id');
    }

    public function flipbook()
    {
        return $this->belongsTo(Flipbook::class,'id');
    }
    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teachers::class);
    }
    public function questions()
    {
        return $this->hasMany(Quiz::class,'id');
    }
    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'flipbook_id', 'flipbook_id'); // Assuming 'flipbook_id' links the quiz to the result
    }
    public function quizAnswers()
    {
        return $this->hasMany(QuizAnswer::class);
    }



}
