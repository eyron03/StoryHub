<?php

namespace App\Policies;

use App\Models\Flipbook;
use App\Models\GradeLevel;
use Illuminate\Auth\Access\Response;

class GradeLevelPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Flipbook $flipbook): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Flipbook $flipbook, GradeLevel $gradeLevel): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Flipbook $flipbook): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Flipbook $flipbook, GradeLevel $gradeLevel): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Flipbook $flipbook, GradeLevel $gradeLevel): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Flipbook $flipbook, GradeLevel $gradeLevel): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Flipbook $flipbook, GradeLevel $gradeLevel): bool
    {
        //
    }
}
