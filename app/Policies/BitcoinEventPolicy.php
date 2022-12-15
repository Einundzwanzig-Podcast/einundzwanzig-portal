<?php

namespace App\Policies;

use App\Models\BitcoinEvent;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BitcoinEventPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     *
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
     * @param  \App\Models\BitcoinEvent  $bitcoinEvent
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, BitcoinEvent $bitcoinEvent)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BitcoinEvent  $bitcoinEvent
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, BitcoinEvent $bitcoinEvent)
    {
        return $bitcoinEvent->created_by === $user->id || $user->can((new \ReflectionClass($this))->getShortName().'.'.__FUNCTION__);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BitcoinEvent  $bitcoinEvent
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, BitcoinEvent $bitcoinEvent)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BitcoinEvent  $bitcoinEvent
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, BitcoinEvent $bitcoinEvent)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BitcoinEvent  $bitcoinEvent
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, BitcoinEvent $bitcoinEvent)
    {
        //
    }
}
