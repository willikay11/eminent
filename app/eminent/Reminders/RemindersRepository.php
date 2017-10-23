<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/23/17
 * Time: 3:37 PM
 */
namespace eminent\Reminders;

use eminent\Models\Reminder;
use eminent\Models\ReminderRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class RemindersRepository
{

    /*
     * Save a reminder request
     */
    public function saveReminderRequest($input)
    {
        $reminders = ReminderRequest::where('email', $input['email'])->first();

        if($reminders)
        {
            return $reminders;
        }else{
            return ReminderRequest::create($input);
        }
    }

    /*
     * Generete a token for the password reset link
     */
    public function generateReminderToken($user)
    {
        $token = sha1(md5(time()));

        $userReminders = Reminder::where('email', $user->email)->get();

        foreach($userReminders as $reminder)
        {
            $reminder->delete();
        }

        Reminder::create([
            'email' => $user->email,
            'token' => Hash::make($token)
        ]);

        return $token;
    }

    /*
     * Set the reminder request as served
     */
    public function serveRequest($user)
    {
        $reminder = ReminderRequest::where('email', $user->email)->first();

        $reminder->served = 1;

        $reminder->served_by = Auth::id();

        $reminder->save();
    }

    /*
     * Confirm the password reset token
     */
    public function checkToken($email, $token)
    {
        $reminder = Reminder::where('email', $email)->first();

        if(! $reminder)
        {
            return 0;

        }elseif(! Hash::check($token, $reminder->token))
        {
            return 0;
        }
        else
        {
            $time_sent = new Carbon($reminder->created_at);

            $time_elapsed = $time_sent->copy()->diffInMinutes(Carbon::now());

            if($time_elapsed > Config::get('auth.passwords.users.expire'))
            {
                return 1;
            }
            return 2;
        }
    }

    /*
     * Clear a user's reminder request
     */
    public function clearUserResetRequest($user)
    {
        $userReminders = Reminder::where('email', $user->email)->get();

        foreach($userReminders as $reminder)
        {
            $reminder->delete();
        }

        $userRequests = ReminderRequest::where('email', $user->email)->get();

        foreach($userRequests as $reminder)
        {
            $reminder->delete();
        }
    }
}