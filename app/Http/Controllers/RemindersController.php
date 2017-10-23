<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/23/17
 * Time: 3:35 PM
 */

namespace App\Http\Controllers;


use App\Events\Users\UserPasswordResetComplete;
use App\Events\Users\UserResetApproved;
use eminent\Reminders\RemindersRepository;
use eminent\Users\UserRules;
use eminent\Users\UsersRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class RemindersController extends Controller
{
    /*
     * Get the rules trait
     */
    use UserRules;

    /*
     * Get the Reminders Repo
     */
    protected $remindersRepository;
    protected $userRepository;

    /*
     * Constructor
     */
    public function __construct(RemindersRepository $remindersRepository, UsersRepository $userRepository)
    {
        $this->remindersRepository = $remindersRepository;
        $this->userRepository = $userRepository;

    }

    /*
     * Display password reminder form
     */
    public function index()
    {
        return view('login.remind');
    }


    /*
     * Authenticate email and send notice to admin
     */
    public function authenticateReminder(Request $request)
    {
        $validation = $this->passwordReminder($request);

        if($validation)
        {
            return back()->withErrors($validation)->withInput();
        }

        $user = $this->userRepository->getUserByEmail($request->get('email'));

        if(! $user)
        {
            Flash::error('No user exists under that email');

            return back();
        }

        $this->remindersRepository->saveReminderRequest($request->all());

        $token = $this->remindersRepository->generateReminderToken($user);

        $this->remindersRepository->serveRequest($user);

        event(new UserResetApproved($user, $token));

        Flash::success('A password reset link has been sent to your email.');

        return redirect('/login');
    }

    /*
     * Send password reset email
     */
    public function remind($id)
    {
        $user = $this->userRepository->getUserById($id);

        $token = $this->remindersRepository->generateReminderToken($user);

        event(new UserResetApproved($user, $token));

        $this->remindersRepository->serveRequest($user);

        Flash::success("Password reset link sent successfully");

        return back();
    }

    /*
     * Authenticate Password Reset Link
     */
    public function authenticateResetLink($id, $token)
    {
        $user = $this->userRepository->getUserById($id);

        $request = $this->remindersRepository->checkToken($user->email, $token);

        if($request == 0)
        {
            Flash::error("Invalid User/Password reset key");

            return redirect('/login');
        }
        elseif($request == 1)
        {
            Flash::error("The password reset token has expired. Kindly request for a new one");

            return redirect('/login');
        }
        else
        {
            return view('login.password', [
                'token' => $token,
                'id' => $id
            ]);
        }
    }

    /*
     * Save the password for the user
     */
    public function savePassword(Request $request, $id)
    {
        $validation = $this->usersPassword($request);

        if($validation)
        {
            return back()->withErrors($validation);
        }

        $user = $this->userRepository->getUserById($id);

        if($user)
        {
            $this->userRepository->reset($user, $request->get('password'));

            event(new UserPasswordResetComplete($user));

            Flash::success('Password reset succesfully. You can now login');

            return redirect('/login');
        }
        else
        {
            Flash::error('Invalid user/reset link');

            return redirect('/login');
        }
    }
}