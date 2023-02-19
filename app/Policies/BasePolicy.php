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
     * @return void|bool
     */
    public function before(User $user, string $ability)
    {
        if ($user->hasRole('super-admin') || config('app.super-admin')) {
            return true;
        }
    }
}
