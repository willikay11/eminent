<?php

namespace App\Listeners\Activities;

use App\Events\Activities\TaskAssigned;
use Carbon\Carbon;
use eminent\Mailers\ActivityMailers;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class WhenTaskAssigned
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
     * @param  TaskAssigned  $event
     * @return void
     */
    public function handle(TaskAssigned $event)
    {
        $activity = $event->activity;

            $data = [
                'firstname' => $activity->user->contact->firstname,
                'to' => $activity->user->email,
                'name' => $activity->name,
                'assigner' => $activity->assigner->contact->present()->fullName,
                'description' => $activity->description,
                'priority' => $activity->priorityType->name,
                'dueDate' => Carbon::parse($activity->due_date)->format('l jS F Y'),
            ];

            ActivityMailers::taskAssignment($data);
    }
}
