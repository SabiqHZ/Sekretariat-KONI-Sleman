<?php

namespace App\Policies;

use App\Models\User;
use App\Models\surats;
use Illuminate\Auth\Access\Response;

class SuratPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, surats $surats): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, surats $surats): bool
    {
        return in_array($user->role, ['administrasi', 'keuangan', 'aset']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, surats $surats): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, surats $surats): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, surats $surats): bool
    {
        return false;
    }
}
