<?php

namespace App\Listeners\Activities;

use App\Events\Activities\TaskStatusUpdated;
use Carbon\Carbon;
use eminent\Mailers\ActivityMailers;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class WhenTaskStatusUpdated
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
     * @param  TaskStatusUpdated  $event
     * @return void
     */
    public function handle(TaskStatusUpdated $event)
    {
        $activity = $event->activity;

        $data = [
            'assigner' => $activity->assigner->contact->firstname,
            'to' => $activity->assigner->email,
            'name' => $activity->name,
            'assigned' => $activity->user->contact->present()->fullName,
            'description' => $activity->description,
            'priority' => $activity->priorityType->name,
            'status' => $activity->activityStatus->name,
            'dueDate' => Carbon::parse($activity->due_date)->format('l jS F Y'),
        ];

        ActivityMailers::taskProgressUpdated($data);
    }
}
