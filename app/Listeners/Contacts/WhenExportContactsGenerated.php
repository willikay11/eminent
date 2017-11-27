<?php

namespace App\Listeners\Contacts;

use App\Events\Contacts\exportContactsGenerated;
use eminent\Mailers\ContactMailers;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class WhenExportContactsGenerated
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
     * @param  exportContactsGenerated  $event
     * @return void
     */
    public function handle(exportContactsGenerated $event)
    {
        $path = $event->path;

        $user = $event->user;

        $data = [
            'to' => Auth::user()->email,
            'firstname' => $user->contact->firstname,
            'path' => $path
        ];

        ContactMailers::sendGeneratedExportReport($data);
    }
}
