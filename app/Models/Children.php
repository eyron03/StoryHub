<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User  as Authenticatable;
class Children extends  Authenticatable
{
    use HasFactory;
    protected $guarded =[];
    public function parent()
{
    return $this->belongsTo(Parents::class);
}
public function quizResults()
    {
        return $this->hasMany(QuizResult::class);
    }



    public function gradeLevel()
    {
        return $this->belongsToMany(GradeLevel::class, 'children_classes', 'child_id', 'class_id');
    }
    public function classes()
    {
        return $this->belongsToMany(GradeLevel::class, 'children_classes', 'child_id', 'class_id');
    }


}
