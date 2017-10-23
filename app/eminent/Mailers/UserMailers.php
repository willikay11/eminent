<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/23/17
 * Time: 9:48 AM
 */

namespace eminent\Mailers;

use Illuminate\Support\Facades\Mail;

class UserMailers
{

    /*
     * Send the one time key email to the user
     */
    public static function oneTimeKey($data)
    {
        $data['subject'] = 'Eminent CRM One Time Login Key';

        Mail::send('emails.users.one_time_key', $data, function ($message) use ($data)
        {
            $message->to($data['email'])->subject($data['subject']);
        });
    }
}