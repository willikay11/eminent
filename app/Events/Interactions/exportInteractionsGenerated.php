<?php

namespace App\Events\Interactions;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class exportInteractionsGenerated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $path;

    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($path, $user)
    {
        $this->path = $path;

        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
//        return new PrivateChannel('channel-name');
    }
}
