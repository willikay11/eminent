<?php

namespace App\Listeners\Activities;

use App\Events\Activities\TaskProgressUpdated;
use eminent\Mailers\ActivityMailers;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class WhenTaskProgressUpdated
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
     * @param  TaskProgressUpdated  $event
     * @return void
     */
    public function handle(TaskProgressUpdated $event)
    {
        $progressUpdate = $event->progressUpdate;

        $activity = $progressUpdate->activity;

        $data = [
            'to' => $activity->assigner->email,
            'cc' => $this->getActivityTaskWatchers($activity),
            'taskname' => $activity->name,
            'description' => $progressUpdate->description,
            'percentage' => $progressUpdate->percentage.'%',
            'user' => $progressUpdate->user->contact->present()->fullName,
        ];

        ActivityMailers::taskProgressUpdated($data);
    }

    public function getActivityTaskWatchers($activity)
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
