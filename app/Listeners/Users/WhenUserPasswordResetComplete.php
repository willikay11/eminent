<?php

namespace App\Listeners\Users;

use App\Events\Users\UserPasswordResetComplete;
use eminent\Reminders\RemindersRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class WhenUserPasswordResetComplete
{
    protected $reminderRepository;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(RemindersRepository $remindersRepository)
    {
        $this->reminderRepository = $remindersRepository;
    }

    /**
     * Handle the event.
     *
     * @param  UserPasswordResetComplete  $event
     * @return void
     */
    public function handle(UserPasswordResetComplete $event)
    {
        $this->reminderRepository->clearUserResetRequest($event->user);
    }
}
