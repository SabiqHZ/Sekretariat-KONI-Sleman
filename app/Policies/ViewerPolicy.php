<?php

namespace App\Policies;

use App\Models\Surat;
use App\Models\Surats;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ViewerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['administrasi', 'keuangan', 'aset']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Surats $surat): bool
    {
        return $user->role->name === 'viewer';
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
    public function update(User $user, Surats $surat): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Surats $surat): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Surats $surat): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Surats $surat): bool
    {
        return false;
    }
}
