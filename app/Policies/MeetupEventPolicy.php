<?php

namespace App\Policies;

use App\Models\MeetupEvent;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MeetupEventPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, MeetupEvent $meetupEvent): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, MeetupEvent $meetupEvent): bool
    {
        return $user->meetups->contains($meetupEvent->meetup) || $user->can((new \ReflectionClass($this))->getShortName().'.'.__FUNCTION__);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, MeetupEvent $meetupEvent): bool
    {
        return false && $meetupEvent->created_by === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, MeetupEvent $meetupEvent): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, MeetupEvent $meetupEvent): bool
    {
        return false;
    }
}
