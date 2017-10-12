<?php

namespace App\Events;

use App\Phone;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class PhoneAdded implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;
    /**
     * @var Phone
     */
    public $phone;

    public function broadcastAs()
    {
        return 'created';
    }

    /**
     * Create a new event instance.
     *
     * @param Phone $phone
     */
    public function __construct(Phone $phone)
    {
        //
        $this->phone = $phone;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('phones');
    }
}
