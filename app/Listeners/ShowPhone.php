<?php

namespace App\Listeners;

use App\Events\PhoneAdded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ShowPhone
{


    /**
     * Create the event listener.
     *
     * @param $user
     */
    public function __construct()
    {
        //

    }

    /**
     * Handle the event.
     *
     * @param  PhoneAdded $event
     *
     * @return void
     */
    public function handle(PhoneAdded $event)
    {
        $phone = $event->phone;
        \Log::info('phone add ShowPhone' . json_encode($phone));
    }
}
