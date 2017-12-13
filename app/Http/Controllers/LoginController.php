<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/23/17
 * Time: 8:13 AM
 */

namespace App\Http\Controllers;

use App\Events\Users\UserAuthenticated;
use eminent\Library\HOTPass;
use eminent\Users\UserRules;
use Illuminate\Http\Request;
use eminent\Users\UsersRepository;
use eminent\Users\SessionRepository;
use Illuminate\Support\Facades\Session;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class LoginController extends Controller
{

    /*
     * Get the rules trait
     */
    use UserRules;

    /*
     * Get the users repository
     */
    protected $usersRepository;

    /*
     * Session Repository
     */
    protected $sessionRepository;

    /*
     * Generate the one time key
     */
    private $keygen;


    public function __construct(UsersRepository $userRepository, SessionRepository $sessionRepository)
    {
        $this->usersRepository = $userRepository;

        $this->keygen = new HOTPass();

        $this->sessionRepository = $sessionRepository;
    }

    public function index()
    {
        return view('login.index');
    }

    public function authenticate(Request $request)
    {
        $validation = $this->login($request);

        if($validation)
        {
            return back()->withErrors($validation)->withInput();
        }

        $email = $request->get('email');

        $password = $request->get('password');

        $user = $this->usersRepository->getUserByEmail($email);

        if(! $user){

            return back()->with('error', 'Email and/or password does not match');
        }

        //Validate the user
        if(Auth::validate(['email' => $email, 'password' => $password, 'active' => 1]))
        {
            //Generate the otp key
            $otp = $this->getOTP($user);

            //Raise event to send email to user
            event(new UserAuthenticated($user, $otp));

            //Save the last login time and reset login attempts

            $this->usersRepository->saveLastLogin($user);

            //Encrypt username and flash it to session

            $loggedIn = serialize(Hash::make($email));

            $request->session()->flash('company_email', $loggedIn);

            return view('login.confirm', [
                'email' => $email
            ])->with('success', 'Enter the 6 digit pin you received in your email to confirm login');

        }else{

            return back()->with('error', 'Email and/or password does not match');
        }
    }

    /*
     * Generate the onetimekey to send to user
     */
    public function getOTP($user)
    {
        $key = Hash::make($user->username);

        $otp =  (String) $this->keygen->generate($key, 1);

        $user->one_time_key = Hash::make($otp);

        $user->one_time_key_created_at = Carbon::now();

        $user->save();

        return $otp;
    }

    public function confirmAuthentication(Request $request, $email)
    {
        $request->request->add(['one_time_key' => trim($request->get('one_time_key'))]);

        $validation = $this->confirm($request);

        if($validation)
        {
            return back()->withErrors($validation)->withInput();
        }

        if($request->session()->has('company_email'))
        {
            $usernameHash = unserialize($request->session()->get('company_email'));

            //confirm session variable matches the route posted to
            if(! Hash::check($email, $usernameHash))
            {//user could not be confirmed as logged in
                Flash::error('You are not logged in');

                return redirect('/login');
            }

            //confirm the otp
            $user = $this->usersRepository->getUserByEmail($email);

            $key = $request->get('one_time_key');

            if(! Hash::check($key,$user->one_time_key))
            {
                Flash::error('Invalid login token. Please enter the correct token you received in your email');

                return redirect('/login')->withInput();
            }

            $minutes_elapsed = (new Carbon($user->one_time_key_created_at))->copy()->diffInMinutes(new Carbon('now'));

            if($minutes_elapsed > 15)
            {
                Flash::error('Login Token expired. Login again to receive a new token');

                return redirect('/login')->withInput();
            }

            //now log in user using username and key
            Auth::login($user);

            //update last login
            $this->usersRepository->saveLastLogin($user);

            //events
            $this->sessionRepository->swapSession($user);

            Flash::success('You are now logged in');

            return redirect()->intended('/');
        }
        else
        {
            Flash::error('You are not logged in');

            return redirect('/login');
        }
    }


    /*
     * Logout a user
     */
    public function destroy()
    {
        if(Auth::guest())
        {
            Flash::error('You are not logged in');

            return redirect('/login');
        }

        Auth::logout();

        Session::flush();

        Flash::message('You have now been Logged out');

        return redirect('/login');
    }
}