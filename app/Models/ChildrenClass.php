<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildrenClass extends Model
{
    use HasFactory;
    protected $guarded =[];
    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class, 'class_id');
    }

    public function child()
    {
        return $this->belongsTo(Children::class, 'child_id');
    }
}
