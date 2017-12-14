<?php

namespace App\Jobs;

use eminent\Mailers\FeedbackMailers;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PostFeedBack implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $feedback;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($feedback)
    {
        $this->feedback = $feedback;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $feedback = $this->feedback;

        $data = [
            'user' => $feedback->user->contact->firstname,
            'subject' => $feedback->subject,
            'post' => $feedback->message,
        ];

        FeedbackMailers::feedBackNotifications($data);
    }
}
