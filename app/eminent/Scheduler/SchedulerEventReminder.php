<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 12/16/17
 * Time: 2:28 PM
 */
namespace eminent\Scheduler;

use App\Events\Events\ReminderNotification;
use Carbon\Carbon;
use eminent\Models\EventReminder;

class SchedulerEventReminder
{
    public static function sendReminders()
    {
        $now = Carbon::now()->format('Y-m-d H:i');

        $now = Carbon::createFromFormat('Y-m-d H:i', $now);

        $tenMinutesAgo = $now->copy()->subMinutes(10);

        $thirtyMinutesAgo = Carbon::now()->subMinutes(30)->format('Y-m-d H:i');

        $thirtyMinutesAgo = Carbon::createFromFormat('Y-m-d H:i', $thirtyMinutesAgo);

        $reminders = EventReminder::where('time','>=', $thirtyMinutesAgo)->where('time', '<=', $tenMinutesAgo)->orWhere('time', $now)->get();

        foreach($reminders as $reminder)
        {
            $event = $reminder->event;

            event(new ReminderNotification($event));

            $reminder->delete();
        }
    }
}