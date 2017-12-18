<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 12/18/17
 * Time: 8:57 PM
 */

namespace eminent\Scheduler;


use Carbon\Carbon;
use eminent\Activities\ActivityRepository;
use eminent\Mailers\ActivityMailers;

class SchedulerEventReminderHandler
{
    public static function send24HourTaskReminder($event)
    {
        $activityRepository = new ActivityRepository();

        $filters = (array)json_decode($event->filters);

        $activityId = $filters['activityId'];

        $activity =  $activityRepository->getActivityById($activityId);

        $data = [
            'firstname' => $event->user->firstname,
            'to' => $activity->user->email,
            'cc' => SchedulerEventReminderHandler::getActivityTaskWatchers($activity),
            'name' => $activity->name,
            'type' => $activity->activityType->name,
            'description' => $activity->description,
            'priority' => $activity->priorityType->name,
            'dueDate' => Carbon::parse($activity->due_date)->format('l jS F Y'),
        ];

        ActivityMailers::task24HourReminder($data);
    }

    public static function send48HourTaskReminder($event)
    {
        $activityRepository = new ActivityRepository();

        $filters = (array)json_decode($event->filters);

        $activityId = $filters['activityId'];

        $activity =  $activityRepository->getActivityById($activityId);

        $data = [
            'firstname' => $event->user->firstname,
            'to' => $activity->user->email,
            'cc' => SchedulerEventReminderHandler::getActivityTaskWatchers($activity),
            'name' => $activity->name,
            'type' => $activity->activityType->name,
            'description' => $activity->description,
            'priority' => $activity->priorityType->name,
            'dueDate' => Carbon::parse($activity->due_date)->format('l jS F Y'),
        ];

        ActivityMailers::task48HourReminder($data);
    }

    public static function getActivityTaskWatchers($activity)
    {
        $emails = array();

        $activityWatchers = $activity->activityWatchers;

        foreach ($activityWatchers as $activityWatcher)
        {
            $emails[] = $activityWatcher->user->email;
        }

        return $emails;
    }
}