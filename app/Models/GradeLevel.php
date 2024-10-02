<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeLevel extends Model
{
    use HasFactory;
    protected $guarded =[];
  
    public function teacher()
    {
        return $this->belongsTo(Teachers::class, 'teacher_id');
    }
    public function children()
    {
        return $this->belongsToMany(Children::class, 'children_classes', 'class_id', 'child_id');
    }
}
