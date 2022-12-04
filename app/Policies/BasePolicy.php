<?php

namespace App\Policies;

use App\Models\User;

class BasePolicy
{
    /**
     * Perform pre-authorization checks.
     *
     * @param  \App\Models\User  $user
     * @param  string  $ability
     *
     * @return void|bool
     */
    public function before(User $user, $ability)
    {
        if ($user->hasRole('super-admin') || app()->environment('local')) {
            return true;
        }
    }
}
