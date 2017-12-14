<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 12/14/17
 * Time: 1:19 PM
 */

namespace eminent\Mailers;


use Illuminate\Support\Facades\Mail;

class FeedbackMailers
{
    public static function feedBackNotifications($data)
    {
        $data['subject'] = 'Eminent CRM : FeedBack Notification';

        Mail::send('emails.feedback.notification', $data, function ($message) use ($data)
        {
            $message->to('willikay11@gmail.com')->subject($data['subject'])->from('eminentCRM@eminent.co.ke')->bcc(getAdmins());
        });
    }
}