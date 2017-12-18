<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 12/18/17
 * Time: 9:26 PM
 */

namespace eminent\EventReminders;

use eminent\Models\EventReminder;

class EventRemindersRepository
{
    public function saveEventReminder($event)
    {
        $reminder = [
            'active' => 1,
            'event_id' => $event->id,
            'time' => $event->start_date
        ];

        return EventReminder::create($reminder);
    }
}