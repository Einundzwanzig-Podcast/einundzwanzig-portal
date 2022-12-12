<?php

namespace App\Policies;

use App\Models\OrangePill;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrangePillPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OrangePill  $orangePill
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, OrangePill $orangePill)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OrangePill  $orangePill
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, OrangePill $orangePill)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OrangePill  $orangePill
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, OrangePill $orangePill)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OrangePill  $orangePill
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, OrangePill $orangePill)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OrangePill  $orangePill
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, OrangePill $orangePill)
    {
        return false;
    }
}
