<?php

namespace App\Policies;

use App\Models\Registration;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RegistrationPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Registration $registration): bool
    {
        return $registration->whereHas('event.course.lecturer',
            fn ($q) => $q->where('team_id', $user->current_team_id))
                            ->exists();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Registration $registration): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Registration $registration): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Registration $registration): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Registration $registration): bool
    {
        //
    }
}
