<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Permission;

class PermissionPolicy extends BasePolicy
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
        return $user->can((new \ReflectionClass($this))->getShortName().'.'.__FUNCTION__);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Permission $permission)
    {
        return $user->can((new \ReflectionClass($this))->getShortName().'.'.__FUNCTION__);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can((new \ReflectionClass($this))->getShortName().'.'.__FUNCTION__);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Permission $permission)
    {
        return $user->can((new \ReflectionClass($this))->getShortName().'.'.__FUNCTION__);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Permission $permission)
    {
        return $user->can((new \ReflectionClass($this))->getShortName().'.'.__FUNCTION__);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Permission $permission)
    {
        return $user->can((new \ReflectionClass($this))->getShortName().'.'.__FUNCTION__);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Permission $permission)
    {
        return $user->can((new \ReflectionClass($this))->getShortName().'.'.__FUNCTION__);
    }
}
