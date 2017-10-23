<?php

namespace App\Listeners\Users;

use App\Events\Users\UserAuthenticated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use eminent\Mailers\UserMailers as UserMailer;

class WhenUserAuthenticated
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
     * @param  UserAuthenticated  $event
     * @return void
     */
    public function handle(UserAuthenticated $event)
    {
        $user = $event->user;

        $otp = $event->otp;

        $data = [
            'name' => $user->contact->firstname,
            'email' => $user->email,
            'otp' => $otp
        ];

        UserMailer::oneTimeKey($data);
    }

}
