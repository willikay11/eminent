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
}