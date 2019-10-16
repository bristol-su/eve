<?php

namespace App\Events;

use App\UcEvent;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class EventUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $event;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(UcEvent $event)
    {
        $this->event = $event;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
