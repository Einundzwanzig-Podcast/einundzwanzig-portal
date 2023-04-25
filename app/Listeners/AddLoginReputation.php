<?php

namespace App\Listeners;

use App\Events\PlebLoggedInEvent;
use App\Gamify\Points\LoggedIn;
use Illuminate\Support\Facades\File;

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
     */
    public function handle(object $event): void
    {
        $event->user->givePoint(new LoggedIn($event->user));
        $text = sprintf("
            Der Hoonig-Dax hat sich gerade eingeloggt.
            Markus Turm ist total begeistert.
            ");
        File::put(storage_path('app/public/tts/honig.txt'), $text);
        dispatch(new \App\Jobs\CodeIsSpeech('honig'))->delay(now()->addSeconds(30));
        event(new PlebLoggedInEvent($event->user->name, $event->user->profile_photo_url));
    }
}
