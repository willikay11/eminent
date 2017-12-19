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

    public static function sendTaskDueReminder()
    {
        $activityRepository = new ActivityRepository();

        $activities = $activityRepository->getTasksDueToday();

        foreach ($activities as $activity)
        {
            $data = [
                'firstname' => $activity->user->firstname,
                'to' => $activity->user->email,
                'cc' => SchedulerEventReminderHandler::getActivityTaskWatchers($activity),
                'name' => $activity->name,
                'type' => $activity->activityType->name,
                'description' => $activity->description,
                'priority' => $activity->priorityType->name,
                'dueDate' => Carbon::parse($activity->due_date)->format('l jS F Y'),
                'content' => SchedulerEventReminderHandler::getTaskDueContent($activity->due_date)
            ];

            ActivityMailers::taskDueReminder($data);
        }
    }

    public static function getTaskDueContent($date)
    {
        $diffInDays = Carbon::parse($date)->endOfDay()->diffInDays(Carbon::now());

        if ($diffInDays == 0)
        {
            return 'The following task is due today ('.Carbon::parse($date)->format('l jS F Y').')';
        }

        return 'The following task was due '.$diffInDays.' days ago';
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