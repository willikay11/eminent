<?php

namespace App\Listeners\Interactions;

use App\Events\Interactions\exportInteractionsGenerated;
use eminent\Mailers\InteractionMailers;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class WhenExportInteractionsGenerated
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
     * @param  exportInteractionsGenerated  $event
     * @return void
     */
    public function handle(exportInteractionsGenerated $event)
    {
        $path = $event->path;

        $user = $event->user;

        $data = [
            'to' => Auth::user()->email,
            'firstname' => $user->contact->firstname,
            'path' => $path
        ];

        InteractionMailers::sendGeneratedExportReport($data);
    }
}
