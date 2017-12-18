<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use eminent\Scheduler\SchedulerEventReminder;
use Illuminate\Console\Command;

class CheckReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eminent:reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        SchedulerEventReminder::sendReminders();

        \Log::info(Carbon::now());
    }
}
