<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    use HasFactory;

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

}
