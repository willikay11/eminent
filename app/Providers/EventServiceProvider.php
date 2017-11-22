<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Users\UserAuthenticated' => [
            'App\Listeners\Users\WhenUserAuthenticated',
        ],
        'App\Events\Users\UserResetApproved' => [
            'App\Listeners\Users\WhenUserResetApproved',
        ],
        'App\Events\Users\UserPasswordResetComplete' => [
            'App\Listeners\Users\WhenUserPasswordResetComplete',
        ],
        'App\Events\Users\UserRegistered' => [
            'App\Listeners\Users\WhenUserRegistered',
        ],
        'App\Events\Contacts\ContactsAssigned' => [
            'App\Listeners\Contacts\WhenContactsAssigned',
        ],
        'App\Events\Activities\TaskAssigned' => [
            'App\Listeners\Activities\WhenTaskAssigned',
        ],
        'App\Events\Activities\TaskStatusUpdated' => [
            'App\Listeners\Activities\WhenTaskStatusUpdated',
        ],
        'App\Events\Activities\TaskCommentPosted' => [
            'App\Listeners\Activities\WhenTaskCommentPosted',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
