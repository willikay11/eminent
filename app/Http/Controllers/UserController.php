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
use eminent\Contacts\ContactsRepository;
use eminent\Models\Country;
use eminent\Models\Department;
use eminent\Models\Designation;
use eminent\Models\Gender;
use eminent\Models\Role;
use eminent\Models\Title;
use eminent\Models\User;
use eminent\Users\UserRules;
use eminent\Users\UsersRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class UserController extends Controller
{

    use SortFilterPaginate;
    use UserRules;

    protected $usersRepository;
    protected $contactsRepository;

    public function __construct(UsersRepository $usersRepository, ContactsRepository $contactsRepository)
    {
        $this->usersRepository = $usersRepository;
        $this->contactsRepository = $contactsRepository;
    }

    public function getUsers()
    {
        $professions = $this->sortFilterPaginate(new User(), [], function ($user)
        {
            return[
                'id' => $user->id,
                'name' => $user->present()->fullName,
                'email' => $user->email,
                'role' => $user->role->name,
                'phone' => $user->contact->phone,
                'active' => $user->present()->activeStatus,
                'designation_id' => $user->designation_id
            ];
        },null, null);

        return self::toResponse(null, $professions);
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
                'value' => (string)$title->id,
                'label' => $title->name
            ];
        });

        $countries = Country::all();

        $countries = $countries->map(function ($country)
        {
            return [
                'value' => (string)$country->id,
                'label' => $country->name
            ];
        });

        $designations = Designation::where('active', 1)->get();

        $designations = $designations->map(function ($designation)
        {
            return [
                'value' => (string)$designation->id,
                'label' => $designation->name
            ];
        });

        $roles = Role::where('active', 1)->get();

        $roles = $roles->map(function ($role)
        {
            return [
                'value' => (string)$role->id,
                'label' => $role->name
            ];
        });

        $genders = Gender::where('active', 1)->get();

        $genders = $genders->map(function ($gender)
        {
            return [
                'value' => (string)$gender->id,
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
        return view('users.index');
    }

    public function storeUser(Request $request)
    {
        $contact = $this->contactsRepository->getContactByEmail($request->get('email'));

        if($contact)
        {
            $this->contactsRepository->updateContact($contact, $request->all());
        }
        else
        {
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
                'message' => "Validation failed"
            ];

            return $response;
        }

        $user = $this->usersRepository->save($request->all(), $request->get('userId'));


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

        return $response;

    }

    public function activation($id, $code)
    {
        $user = $this->usersRepository->getUserById($id);

        if($user)
        {
            if(is_null($user->activation_key) && $user->active == 1)
            {
                Flash::error('Account is already activated, you can now login');

                return redirect('/login');
            }
            if($user->activation_key == $code)
            {
                if(! $this->usersRepository->checkActivationKeyExpiry( $user->activation_key_created_at ))
                {
                    Flash::error('Activation Key has expired, please request a new one from the administrator');

                    return redirect('/login');
                }

                Flash::success('Account activated succesfully. Now create a new password for your account');

                return redirect('/users/create_password/'. $code);
            }
            else
            {
                Flash::error('Could not activate that user, check that the activation link is correct or contact the administrator');

                return redirect('/login');
            }
        }
        else
        {
            Flash::error('Could not activate account, check that the activation link is correct or whether account is already activated or contact the administrator');

            return redirect('/login');
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
                Flash::error('Activation Key has expired, please request a new one');

                return redirect('/');
            }

            $this->usersRepository->activate($user, $request->all());

            Flash::success('Password created succesfully. You can now login');

            return redirect('/');
        }
        else
        {
            Flash::error('Could not activate that user, check that the activation link is correct.');

            return redirect('/');
        }
    }

    public function userRoles($id)
    {
        return view('users.roles', [
            'userId' => $id
        ]);
    }

    public function toResponse($request = null, $data)
    {
        return response($data);
    }
}