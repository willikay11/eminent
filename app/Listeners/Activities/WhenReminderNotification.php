<?php

namespace App\Listeners\Activities;

use App\Events\Events\ReminderNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class WhenReminderNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ReminderNotification  $event
     * @return void
     */
    public function handle(ReminderNotification $event)
    {
        $type = $event->event->type;

        switch ($type)
        {
            case ($type == 1): {

                \Log::info($event->event->name);
            }
        }
    }
}
