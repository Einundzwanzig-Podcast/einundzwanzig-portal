<?php

namespace App\Policies;

use App\Models\CourseEvent;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CourseEventPolicy extends BasePolicy
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
     * @param  \App\Models\CourseEvent  $courseEvent
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, CourseEvent $courseEvent)
    {
        return $user->is_lecturer;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->is_lecturer;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CourseEvent  $courseEvent
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, CourseEvent $courseEvent)
    {
        return $user->belongsToTeam($courseEvent->course->lecturer->team) || $user->can((new \ReflectionClass($this))->getShortName().'.'.__FUNCTION__);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CourseEvent  $courseEvent
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, CourseEvent $courseEvent)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CourseEvent  $courseEvent
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, CourseEvent $courseEvent)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CourseEvent  $courseEvent
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, CourseEvent $courseEvent)
    {
        //
    }
}
