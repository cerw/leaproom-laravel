<?php

namespace App\Listeners;

use App\Events\PhoneAdded;

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
     * @param PhoneAdded $event
     *
     * @return void
     */
    public function handle(PhoneAdded $event)
    {
        $phone = $event->phone;
        \Log::info('phone add ShowPhone'.json_encode($phone));
    }
}
