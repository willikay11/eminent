<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 12/18/17
 * Time: 9:23 PM
 */
namespace eminent\Events;

use Carbon\Carbon;
use eminent\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventsRepository
{
    public function save24HourTaskEvent($activity)
    {
        $startDate = Carbon::createFromFormat('Y-m-d H:i', Carbon::parse($activity->due_date)->format('Y-m-d H:i'))->subDay(1);

        $endDate = $startDate->copy()->addMinute(5);

        $eventArray = [
            'user_id' => Auth::id(),
            'name' => '24 Hour Task Reminder',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'type' => 1,
            'where' => 'Unspecified',
            'filters' => json_encode(['activityId' => $activity->id]),
            'description' => 'Send a 24 Hour reminder to task assignee'
        ];

        return Event::create($eventArray);
    }

    public function save48HourTaskEvent($activity)
    {
        $startDate = Carbon::createFromFormat('Y-m-d H:i', Carbon::parse($activity->due_date)->format('Y-m-d H:i'))->subDay(2);

        $endDate = $startDate->copy()->addMinute(5);

        $eventArray = [
            'user_id' => Auth::id(),
            'name' => '48 Hour Task Reminder',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'type' => 2,
            'where' => 'Unspecified',
            'filters' => json_encode(['activityId' => $activity->id]),
            'description' => 'Send a 24 Hour reminder to task assignee'
        ];

        return Event::create($eventArray);
    }
}