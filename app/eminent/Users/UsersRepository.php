<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/23/17
 * Time: 9:04 AM
 */

namespace eminent\Users;

use Carbon\Carbon;
use eminent\Models\Contact;
use eminent\Models\User;
use Illuminate\Support\Facades\Config;

class UsersRepository
{

    /*
     * Get a user by their id
     */
    public function getUserById($id)
    {
        return User::findOrFail($id);
    }

    /*
     * Check if a user exists by their email
     */
    public function getUserByEmail($email)
    {
        $user = User::where('email', $email)->first();

        return $user;
    }

    public function getAllActiveUsers()
    {
        return User::where('active', 1)->get();
    }

    public function getAllActiveUsersForReassign($userId)
    {
        return User::where('active', 1)->where('id', '!=', $userId)->get();
    }
    /*
     * Save Last Login and Reset the Logins
     */
    public function saveLastLogin($user)
    {
        $user->last_login = Carbon::now();

        $user->save();
    }

    /*
     * Reset the users password
     */
    public function reset($user, $password)
    {
        $user->password = $password;

        $user->save();
    }

    public function revoke($id)
    {
        $user = $this->getUserById($id);

        $user->role_id = null;

        $user->save();
    }

    public function save($input, $id)
    {
        $input['contact_id'] = Contact::where('email', $input['email'])->first()->id;

        if(is_null($id))
        {
            $input['activation_key'] = sha1(md5(time()));

            $input['activation_key_created_at'] = Carbon::now();

            $user = User::create($input);

        }else{
            $user = User::findOrFail($id);

            $user->update($input);
        }

        return $user;
    }

    public function checkActivationKeyExpiry( $time )
    {
        $time_sent = new Carbon($time);

        $time_elapsed = $time_sent->copy()->diffInMinutes(Carbon::now());

        if($time_elapsed > Config::get('auth.activation.expire'))
        {
            return false;
        }
        return true;
    }

    public function getUserByCode($code)
    {
        return User::where('activation_key', $code)->first();
    }

    public function activate($user, $input)
    {
        $user->activation_key = null;

        $user->active = 1;

        $user->password = $input['password'];

        $user->save();
    }
}