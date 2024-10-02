<?php

namespace App\Policies;

use App\Models\Flipbook;
use App\Models\Quiz;
use Illuminate\Auth\Access\Response;

class QuizPolicy
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
    public function view(Flipbook $flipbook, Quiz $quiz): bool
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
    public function update(Flipbook $flipbook, Quiz $quiz): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Flipbook $flipbook, Quiz $quiz): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Flipbook $flipbook, Quiz $quiz): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Flipbook $flipbook, Quiz $quiz): bool
    {
        //
    }
}
