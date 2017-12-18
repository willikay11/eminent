<?php

namespace App\Listeners\Activities;

use App\Events\Events\ReminderNotification;
use eminent\Scheduler\SchedulerEventReminderHandler;
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

        $event = $event->event;

        switch ($type)
        {
            case ($type == 1): {
                SchedulerEventReminderHandler::send24HourTaskReminder($event);

                break;
            }
            case ($type == 2): {
                SchedulerEventReminderHandler::send48HourTaskReminder($event);

                break;
            }
        }
    }
}
