<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/27/17
 * Time: 11:55 AM
 */

namespace eminent\Mailers;


use Illuminate\Support\Facades\Mail;

class InteractionMailers
{
    public static function sendGeneratedExportReport($data)
    {
        $data['subject'] = 'Eminent CRM : Interaction Generated Report Notification';

        Mail::send('emails.interactions.interactions_generated', $data, function($message) use ($data)
        {
            $message->to($data['to'])->subject($data['subject']);

            $message->attach(storage_path('excels/'. $data['path']));
        });
    }
}