<?php

namespace App\Policies;

use App\Models\Flipbook;
use App\Models\Login;
use Illuminate\Auth\Access\Response;

class LoginPolicy
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
    public function view(Flipbook $flipbook, Login $login): bool
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
    public function update(Flipbook $flipbook, Login $login): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Flipbook $flipbook, Login $login): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Flipbook $flipbook, Login $login): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Flipbook $flipbook, Login $login): bool
    {
        //
    }
}
