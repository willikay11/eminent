<?php

namespace App\Listeners\Activities;

use App\Events\Activities\TaskCommentPosted;
use eminent\Mailers\ActivityMailers;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class WhenTaskCommentPosted
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
     * @param  TaskCommentPosted  $event
     * @return void
     */
    public function handle(TaskCommentPosted $event)
    {
        $comment = $event->comment;

        $activity = $comment->activity;

        $data = [
            'to' => $activity->assigner->email,
            'cc' => $this->getActivityTaskWatchers($activity),
            'taskname' => $activity->name,
            'user' => $comment->user->contact->present()->fullName,
        ];

        ActivityMailers::taskCommentPosted($data);
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
