<?php

namespace App\Listeners;

use App\Gamify\Points\LoggedIn;

class AddLoginReputation
{
    /**
     * Create the event listener.
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     *
     * @return void
     */
    public function handle($event)
    {
        $event->user->givePoint(new LoggedIn($event->user));
    }
}
