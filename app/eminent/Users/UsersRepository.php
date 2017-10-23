<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/23/17
 * Time: 9:04 AM
 */

namespace eminent\Users;

use Carbon\Carbon;
use eminent\Models\User;

class UsersRepository
{

    /*
     * Check if a user exists by their email
     */
    public function getUserByEmail($email)
    {
        $user = User::where('email', $email)->first();

        return $user;
    }

    /*
     * Save Last Login and Reset the Logins
     */
    public function saveLastLogin($user)
    {
        $user->last_login = Carbon::now();

        $user->save();
    }
}