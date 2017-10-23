<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/23/17
 * Time: 9:13 AM
 */

namespace eminent\Users;


use eminent\Models\User;
use Illuminate\Support\Facades\Session;

class SessionRepository
{
    /**
     * When user logs in, the old session is destroyed so that only one session exists at a time
     * @param User $user
     */
    public function swapSession(User $user) {
        $new_sessid   = Session::getId(); //get new session_id after user sign in

        try{
            $last_session = Session::getHandler()->read($user->last_sessid); // retrive last session
        }
        catch(\Exception $e)
        {
            $last_session = false;
        }

        if ($last_session)
        {
            Session::getHandler()->destroy($user->last_sessid);
        }

        $user->last_sessid = $new_sessid;

        $user->save();
    }

    public function destroySession(User $user) {
        try{
            $last_session = Session::getHandler()->read($user->last_sessid); // retrive last session
        }
        catch(\Exception $e)
        {
            $last_session = false;
        }

        if ($last_session)
        {
            Session::getHandler()->destroy($user->last_sessid);
        }

        $user->last_sessid = null;

        $user->save();
    }
}