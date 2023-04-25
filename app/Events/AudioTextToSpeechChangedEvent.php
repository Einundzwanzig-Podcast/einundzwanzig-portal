<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AudioTextToSpeechChangedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public string $src)
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     */
    public function broadcastOn(): \Illuminate\Broadcasting\Channel|array
    {
        return new Channel('plebchannel');
    }
}
