<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/26/17
 * Time: 10:24 AM
 */

namespace App\Http\Controllers;


use App\Events\Users\UserRegistered;
use eminent\API\SortFilterPaginate;
use eminent\Authorization\Authorizer;
use eminent\Contacts\ContactRules;
use eminent\Contacts\ContactsRepository;
use eminent\Models\Country;
use eminent\Models\Department;
use eminent\Models\Designation;
use eminent\Models\Gender;
use eminent\Models\Role;
use eminent\Models\Title;
use eminent\Models\User;
use eminent\UserHasRoles\UserHasRolesRepository;
use eminent\Users\UserRules;
use eminent\Users\UsersRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class UserController extends Controller
{

    use SortFilterPaginate;

    use UserRules;

    use Authorizer;

    protected $usersRepository;

    protected $contactsRepository;
    /**
     * @var UserHasRolesRepository
     */
    private $userHasRolesRepository;

    public function __construct(UsersRepository $usersRepository,
                                ContactsRepository $contactsRepository,
                                UserHasRolesRepository $userHasRolesRepository)
    {
        $this->usersRepository = $usersRepository;
        $this->contactsRepository = $contactsRepository;
        $this->userHasRolesRepository = $userHasRolesRepository;
    }

    public function getUsers()
    {
        $professions = $this->sortFilterPaginate(new User(), [], function ($user)
        {
            return[
                'id' => $user->id,
                'contact_id' => $user->contact->id,
                'name' => $user->present()->fullName,
                'email' => $user->email,
                'phone' => (int)$user->contact->phone,
                'active' => $user->present()->activeStatus,
                'designation_id' => $user->designation_id,
                'title_id' => $user->contact->title_id,
                'firstname' => $user->contact->firstname,
                'lastname' => $user->contact->lastname,
                'gender_id' => $user->contact->gender_id,
                'country_id' => $user->contact->country_id,
                'department_id' => $user->department_id,
                'employment_date' => $user->employment_date,
                'roles' => $this->getUserRoles($user)
            ];
        },null, null);

        return self::toResponse(null, $professions);
    }

    public function getUserRoles($user)
    {
        $userHasRoles = $user->userHasRoles;

        return $userHasRoles->map(function ($userHasRole)
        {
            return [
                'value' => $userHasRole->role->id,
                'label' => $userHasRole->role->name
            ];
        });
    }

    public function getInformation()
    {
        $departments = Department::where('active', 1)->get();

        $departments = $departments->map(function ($department)
        {
            return [
                'value' => $department->id,
                'label' => $department->name
            ];
        });

        $titles = Title::where('active', 1)->get();

        $titles = $titles->map(function ($title)
        {
            return [
                'value' => $title->id,
                'label' => $title->name
            ];
        });

        $countries = Country::all();

        $countries = $countries->map(function ($country)
        {
            return [
                'value' => $country->id,
                'label' => $country->name
            ];
        });

        $designations = Designation::where('active', 1)->get();

        $designations = $designations->map(function ($designation)
        {
            return [
                'value' => $designation->id,
                'label' => $designation->name
            ];
        });

        $roles = Role::where('active', 1)->get();

        $roles = $roles->map(function ($role)
        {
            return [
                'value' => $role->id,
                'label' => $role->name
            ];
        });

        $genders = Gender::where('active', 1)->get();

        $genders = $genders->map(function ($gender)
        {
            return [
                'value' => $gender->id,
                'label' => $gender->name
            ];
        });


        $data = [
            'departments' => $departments,
            'titles' => $titles,
            'countries' => $countries,
            'designations' => $designations,
            'roles' => $roles,
            'genders' => $genders
        ];

        return self::toResponse(null, $data);
    }

    public function index()
    {
        $this->hasPermission('manageUsers');

        return view('users.index');
    }

    public function storeUser(Request $request)
    {
        $this->hasPermission('manageUsers');

        list($user, $domain) = explode('@', $request->get('email'));

        if ((strtolower($domain) != 'eminent.co.ke') && (strtolower($domain != 'sterlingq.com')))
        {
            $response = [
                'success' => false,
                'message' => "The email must be either eminent.co.ke or sterlingq.com",
            ];

            return self::toResponse(null, $response);
        }

        $contact = $this->contactsRepository->getContactByEmail($request->get('email'));

        if($contact)
        {
            $validation = $this->editContactFromUser($request, $contact->id);

            if ($validation)
            {
                $response = [
                    'success' => false,
                    'message' => "Validation failed",
                    'errors' => array_flatten($validation->messages()->getMessages())
                ];

                return self::toResponse(null, $response);
            }

            $this->contactsRepository->updateContact($contact, $request->all());
        }
        else
        {
            $validation = $this->createContactFromUser($request);

            if ($validation)
            {
                $response = [
                    'success' => false,
                    'message' => "Validation failed",
                    'errors' => array_flatten($validation->messages()->getMessages())
                ];

                return self::toResponse(null, $response);
            }

            $this->contactsRepository->save($request->all());
        }

        if(is_null($request->get('userId')))
        {
            $validation = $this->usersCreate($request);
        }else
        {
            $validation = $this->usersUpdate($request);
        }

        if($validation)
        {
            $response = [
                'success' => false,
                'message' => "Validation failed",
                'errors' => array_flatten($validation->messages()->getMessages())
            ];

            return self::toResponse(null, $response);
        }

        $user = $this->usersRepository->save($request->all(), $request->get('userId'));

        $roles = $request->get('roles');

        $this->userHasRolesRepository->deleteAllUserRoles($user->id);

        foreach ($roles as $role)
        {
            $input = [
                'user_id' => $user->id,
                'role_id' => $role['value']
            ];

            $this->userHasRolesRepository->create($input);
        }

        if(is_null($request->get('userId')))
        {
            event(new UserRegistered($user));

            $response = [
                'success' => true,
                'message' => "User created successfully"
            ];
        }
        else
        {
            $response = [
                'success' => true,
                'message' => "User updated successfully"
            ];
        }

        return self::toResponse(null, $response);

    }

    public function activation($id, $code)
    {
        $user = $this->usersRepository->getUserById($id);

        if($user)
        {
            if(is_null($user->activation_key) && $user->active == 1)
            {
                Flash('Account is already activated, you can now login')->error();

                return redirect('/login');
            }
            if($user->activation_key == $code)
            {
                if(! $this->usersRepository->checkActivationKeyExpiry( $user->activation_key_created_at ))
                {
//                    Flash('Activation Key has expired, please request a new one from the administrator')->error();

                    return redirect('/login')->with('error', 'Activation Key has expired, please request a new one from the administrator');
                }

//                Flash('Account activated successfully. Now create a new password for your account')->success();

                return redirect('/users/create_password/'. $code)->with('success', 'Account activated successfully. Now create a new password for your account');
            }
            else
            {
//                Flash('Could not activate that user, check that the activation link is correct or contact the administrator')->error();

                return redirect('/login')->with('error', 'Could not activate that user, check that the activation link is correct or contact the administrator');
            }
        }
        else
        {
//            Flash('Could not activate account, check that the activation link is correct or whether account is already activated or contact the administrator')->error();

            return redirect('/login')->with('error', 'Could not activate account, check that the activation link is correct or whether account is already activated or contact the administrator');
        }
    }

    public function createPassword($id)
    {
        return view('login.create_password', [
            'id' => $id
        ]);
    }

    public function savePassword(Request $request, $code)
    {
        $validation = $this->usersPassword($request);

        if($validation)
        {
            return back()->withErrors($validation);
        }

        $user = $this->usersRepository->getUserByCode($code);

        if($user)
        {
            if(! $this->usersRepository->checkActivationKeyExpiry( $user->activation_key_created_at ))
            {
//                Flash::error('Activation Key has expired, please request a new one');

                return redirect('/')->with('error', 'Activation Key has expired, please request a new one');
            }

            $this->usersRepository->activate($user, $request->all());

//            Flash::success('Password created successfully. You can now login');

            return redirect('/')->with('success', 'Password created successfully. You can now login');
        }
        else
        {
//            Flash::error('Could not activate that user, check that the activation link is correct.');

            return redirect('/')->with('error', 'Could not activate that user, check that the activation link is correct.');
        }
    }

    public function userRoles($id)
    {
        $this->hasPermission('manageUsers');

        return view('users.roles', [
            'userId' => $id
        ]);
    }

    public function resendActivation($id)
    {
        $this->hasPermission('manageUsers', true);

        $user = $this->usersRepository->getUserById($id);

        $user = $this->usersRepository->resendActivation($user);

        event(new UserRegistered($user));

        $response = [
            'success' => true,
            'message' => "Account activation email resent successfully",
        ];

        return self::toResponse(null, $response);
    }

    public function toResponse($request = null, $data)
    {
        return response($data);
    }
}