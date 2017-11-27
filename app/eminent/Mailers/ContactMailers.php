<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/8/17
 * Time: 4:07 PM
 */

namespace eminent\Mailers;


use Illuminate\Support\Facades\Mail;

class ContactMailers
{
    public static function contactAssign($data)
    {
        $data['subject'] = 'Eminent CRM : Contact Assigned Notification';

        Mail::send('emails.contacts.assigned', $data, function ($message) use ($data)
        {
            $message->to($data['to'])->subject($data['subject'])->cc($data['cc']);
        });
    }

    public static function sendEmailtoUsersonReassign($data)
    {
        Mail::send('emails.contacts.reassigned', $data, function($message) use ($data)
        {
            $message->to($data['to'])->subject($data['subject'])->cc($data['cc']);
        });
    }

    public static function sendGeneratedExportReport($data)
    {
        $data['subject'] = 'Eminent CRM : Contact Generated Report Notification';

        Mail::send('emails.contacts.contacts_generated', $data, function($message) use ($data)
        {
            $message->to($data['to'])->subject($data['subject']);

            $message->attach(storage_path('excels/'. $data['path']));
        });
    }
}