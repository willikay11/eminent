<?php

namespace App\Listeners\Contacts;

use App\Events\Contacts\ContactsAssigned;
use eminent\Mailers\ContactMailers;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class WhenContactsAssigned
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
     * @param  ContactsAssigned  $event
     * @return void
     */
    public function handle(ContactsAssigned $event)
    {
        $users = $event->users;

        foreach($users as $user)
        {

            $data = [
                'to' => $user['email'],
                'total' => $user['total'],
                'firstname' => $user['firstname'],
                'subject' => 'Client Reassignment',
                'cc' => Auth::user()->email,
            ];

            ContactMailers::sendEmailtoUsersonReassign($data);
        }
    }
}
