<?php

namespace App\Listeners\Users;

use App\Events\Users\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use eminent\Mailers\UserMailers;

class WhenUserRegistered
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
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $user = $event->user;

        $data = [
            'firstname' => $user->contact->firstname,
            'id' => $user->id,
            'email' => $user->email,
            'code' => $user->activation_key
        ];

        UserMailers::userActivation($data);
    }
}
