<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/21/17
 * Time: 8:47 PM
 */

namespace eminent\Mailers;

use Illuminate\Support\Facades\Mail;

class ActivityMailers
{
    public static function taskAssignment($data)
    {
        $data['subject'] = 'Eminent CRM : Task Assignment Notification';

        Mail::send('emails.activities.taskAssigned', $data, function ($message) use ($data)
        {
            $message->to($data['to'])->subject($data['subject']);
        });
    }

    public static function taskProgressUpdated($data)
    {
        $data['subject'] = 'Eminent CRM : Task Status Update Notification';

        Mail::send('emails.activities.taskStatusUpdated', $data, function ($message) use ($data)
        {
            $message->to($data['to'])->subject($data['subject']);
        });
    }
}