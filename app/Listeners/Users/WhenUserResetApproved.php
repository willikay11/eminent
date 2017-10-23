<?php

namespace App\Listeners\Users;

use App\Events\Users\UserResetApproved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use eminent\Mailers\UserMailers as UserMailer;

class WhenUserResetApproved
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
     * @param  UserResetApproved  $event
     * @return void
     */
    public function handle(UserResetApproved $event)
    {
        $user = $event->user;

        $data = [
            'email' => $user->email,
            'id' => $user->id,
            'token' => $event->token
        ];

        UserMailer::sendPasswordResetLink($data);
    }
}
