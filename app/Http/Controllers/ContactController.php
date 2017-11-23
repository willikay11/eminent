<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/29/17
 * Time: 9:54 AM
 */

namespace App\Http\Controllers;


use App\Events\Contacts\ContactsAssigned;
use eminent\API\SortFilterPaginate;
use eminent\Authorization\Authorizer;
use eminent\Clients\ClientsRepository;
use eminent\Contacts\ContactRules;
use eminent\Contacts\ContactsRepository;
use eminent\Interests\InterestsRepository;
use eminent\Models\Contact;
use eminent\Models\Country;
use eminent\Models\Gender;
use eminent\Models\InteractionType;
use eminent\Models\Service;
use eminent\Models\Profession;
use eminent\Models\Religions;
use eminent\Models\Sources;
use eminent\Models\Status;
use eminent\Models\Title;
use eminent\UserClients\UserClientsRepository;
use eminent\Users\UsersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{

    use ContactRules;

    use SortFilterPaginate;

    use Authorizer;

    protected $contactsRepository;
    protected $clientsRepository;
    protected $userClientsRepository;
    protected $interestsRepository;
    protected $usersRepository;

    public function __construct(ContactsRepository $contactsRepository,
                                ClientsRepository $clientsRepository,
                                UserClientsRepository $userClientsRepository,
                                InterestsRepository $interestsRepository,
                                UsersRepository $usersRepository)
    {
        $this->contactsRepository = $contactsRepository;
        $this->clientsRepository = $clientsRepository;
        $this->userClientsRepository = $userClientsRepository;
        $this->interestsRepository = $interestsRepository;
        $this->usersRepository = $usersRepository;
    }

    public function getInfo($userId)
    {
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

        $genders = Gender::where('active', 1)->get();

        $genders = $genders->map(function ($gender)
        {
            return [
                'value' => $gender->id,
                'label' => $gender->name
            ];
        });

        $sources = Sources::where('active', 1)->get();

        $sources = $sources->map(function ($source)
        {
            return [
                'value' => $source->id,
                'label' => $source->name
            ];
        });

        $services = Service::where('active', 1)->get();

        $services = $services->map(function ($service)
        {
            return [
                'value' => $service->id,
                'label' => $service->name
            ];
        });

        $religions = Religions::where('active', 1)->get();

        $religions = $religions->map(function ($religion)
        {
            return [
                'value' => $religion->id,
                'label' => $religion->name
            ];
        });

        $professions = Profession::where('active', 1)->get();

        $professions = $professions->map(function ($profession)
        {
            return [
                'value' => $profession->id,
                'label' => $profession->name
            ];
        });

        $users = $this->usersRepository->getAllActiveUsersForReassign($userId);

        $users = $users->map(function ($user)
        {
            return [
                'id' => $user->id,
                'name' => $user->contact->present()->fullName
            ];
        });

        $selectedUser = $this->usersRepository->getUserById($userId);

        $selectedUser = [
            'id' => $selectedUser->id,
            'name' => $selectedUser->contact->present()->fullName,
            'email' => $selectedUser->email
        ];

        $data = [
            'sources' => $sources,
            'titles' => $titles,
            'countries' => $countries,
            'services' => $services,
            'genders' => $genders,
            'professions' => $professions,
            'religions' => $religions,
            'users' => $users->toArray(),
            'selectedUser' => $selectedUser
        ];

        return self::toResponse(null, $data);
    }


    public function getContacts()
    {
        $contacts = $this->sortFilterPaginate(new Contact(), [], function ($contact)
        {
            return[
                'id' => $contact->id,
                'name' => $contact->present()->fullName,
                'email' => $contact->email,
                'phone' => $contact->phone,
                'clientExists' => $contact->present()->clientExists,
                'status' => $contact->present()->checkContactType,
                'type' => $contact->type,
                'source' => $contact->present()->contactSource
            ];
        },null, null);

        return $this->toResponse(null, $contacts);
    }


    public function getUserClients($userId)
    {
        $authorized = $this->hasPermission('viewMyContacts', true);

        if (is_array($authorized))
        {
            return self::toResponse(null, $authorized);
        }

        $filterFunc = function ($q) use ($userId)
        {
            return $q->whereHas('clients', function ($q) use ($userId)
            {
                $q->whereHas('userClient', function ($q) use ($userId)
                {
                    $q->where('user_id', $userId);
                });
            });
        };

        $contacts = $this->sortFilterPaginate(new Contact(), [], function ($contact)
        {
            return[
                'id' => $contact->present()->getUserClientId(Auth::id()),
                'contactId' => $contact->id,
                'name' => $contact->present()->fullName,
                'firstName' => $contact->firstname,
                'lastName' => $contact->lastname,
                'title_id' => $contact->title_id,
                'gender_id' => $contact->gender_id,
                'profession_id' => $contact->profession_id,
                'religion_id' => $contact->religion_id,
                'country_id' => $contact->country_id,
                'source_id' => $contact->clients->source_id,
                'email' => $contact->email,
                'phone' => (int)$contact->phone,
                'status' => $contact->present()->clientStatus,
                'source' => $contact->present()->contactSource,
                'type' => $contact->type,
            ];
        },$filterFunc, null);

        return $this->toResponse(null, [
            'success' => true,
            'contacts' => $contacts,
            'messgae' => 'Contacts loaded'
        ]);
    }

    public function getDetails($id)
    {
        $userClient = $this->userClientsRepository->getUserClientById($id);

        $contact = $userClient->client->contact;

        $contact = [
            'name' => $contact->titleName->name.' '.$contact->present()->fullName,
            'email' => $contact->email,
            'phone' => $contact->phone,
            'interactionDate' => $userClient->next_interaction_date,
            'user' => $userClient->user->contact->present()->fullName,
            'status' => $userClient->client->status_id
        ];

        $statuses = Status::all()->map(function ($status)
        {
            return [
                'value' => $status->id,
                'label' => $status->name
            ];
        });

        $interactionTypes = InteractionType::all()->map(function ($interaction)
        {
            return [
                'value' => $interaction->id,
                'label' => $interaction->name
            ];
        });

        $data = [
            'contact' => $contact,
            'statuses' => $statuses,
            'interactionTypes' => $interactionTypes
        ];

        return $this->toResponse(null, $data);
    }

    public function index($userId = null)
    {
        if(is_null($userId))
        {
            $userId = Auth::id();
        }

        return view('contacts.index', [
            'userId' => $userId
        ]);
    }

    public function contacts()
    {
        return view('contacts.contacts');
    }

    public function store(Request $request)
    {
        if($request->has('email'))
        {
            $request->merge(['email' => $this->formatEmail($request->get('email'))]);
        }

        if($request->has('phone'))
        {
            $request->merge(['phone' => $this->formatPhoneNumber($request->get('phone'))]);
        }

        if(!is_null($request->get('contactId')))
        {
            $validation = $this->contactsEdit($request);

            if($validation)
            {
                $validation = $this->checkValidationError($validation, $request);

                $errorArray = $validation->messages()->getMessages();

                return self::toResponse(null, [
                    'success' => false,
                    'errorMessages' => array_flatten($errorArray),
                ]);
            }

            $contact = $this->contactsRepository->save($request->all());

            $this->clientsRepository->save($contact, $request->get('source_id'), $request->get('contactId'));

            return self::toResponse(null, [
                'success' => true,
                'message' => 'Contact updated successfully'
            ]);
        }
        else
        {
            $validation = $this->contactsCreate($request);

            if($validation)
            {
                $validation = $this->checkValidationError($validation, $request);

                $errorArray = $validation->messages()->getMessages();

                return self::toResponse(null, [
                    'success' => false,
                    'errorMessages' => array_flatten($errorArray),
                ]);
            }

            $contact = $this->contactsRepository->save($request->all());

            $client = $this->clientsRepository->save($contact, $request->get('source_id'), null);

            if($request->get('services') != '')
            {
                $services = $request->get('services');

                foreach ($services as $service)
                {
                    $this->interestsRepository->save($service['value'], $client->id);
                }
            }

            if($request->get('user_id') != '')
            {
                $userClient = $this->userClientsRepository->save($client, $request->get('user_id'));
            }
            else
            {
                $userClient = $this->userClientsRepository->save($client, Auth::id());
            }

            return self::toResponse(null, [
                'success' => true,
                'message' => 'Contact added successfully'
            ]);
        }
    }

    public function details($id)
    {
        return view('contacts.details', [
            'id' => $id
        ]);
    }

    /*
     * Format the email before saving
     */
    public function formatEmail($email)
    {
        return strtolower(trim($email));
    }

    /*
     * Format the phone number before saving
     */
    public function formatPhoneNumber1($phonenumber)
    {
        return str_replace(' ', '', trim($phonenumber));
    }

    /*
     * Format the phone number before saving
     */
    public function formatPhoneNumber($phonenumber)
    {
        return preg_replace('/\D/', '', trim($phonenumber));
    }

    /**
     * Check the validation error
     */
    public function checkValidationError($validation, $request)
    {
        $messages = $validation->messages()->getMessages();

        foreach($messages as $key => $message)
        {
            if($key == 'email')
            {
                $contact = $this->contactsRepository->getContactByEmail($request->get('email'));

                if(! is_null($contact))
                {
                    $user = $contact->present()->userClient;

                    $userEmail = $contact->present()->userEmail;

                    if(! is_null($user))
                    {
                        $validation->messages()->merge(
                            [
                                'email' => "The client with that email address is assigned to " . $user . ' (' . $userEmail . ')'
                            ]);
                    }
                }
            }

            if($key == 'phone')
            {
                $contact = $this->contactsRepository->getContactByPhone($request->get('phone'));

                if(! is_null($contact))
                {
                    $user = $contact->present()->userClient;

                    $userEmail = $contact->present()->userEmail;

                    if(! is_null($user))
                    {
                        $validation->messages()->merge(
                            [
                                'phone' => "The client with that phone number is assigned to " . $user . ' (' . $userEmail . ')'
                            ]);
                    }
                }
            }
        }

        return $validation;
    }

    public function reassignContacts(Request $request)
    {
        $validation = $this->clientReassign($request);

        if($validation)
        {
            return self::toResponse([
                'success' => false,
                'message' => 'Validation Failed'
            ]);
        }

        $assignedUsers = $request->get('assigned');

        $userArray = array();

        foreach($assignedUsers as $assignedUser)
        {
            $user = $this->usersRepository->getUserById($assignedUser['id']);

            $userArray[] = [
                'firstname' => $user->contact->firstname,
                'email' => $user->email,
                'id' => $user->id,
                'total' => 0
            ];

        }

        $user = $this->usersRepository->getUserById($request->get('user_id'));

        $chuckedClients = array_chunk($user->userClients->toArray(), count($assignedUsers));

        $userArray = $this->userClientsRepository->saveAssignedContacts($chuckedClients, $userArray);

        event(new ContactsAssigned($userArray));

        return self::toResponse(null, [
            'success' => true,
            'message' => 'The contacts have been assigned successfully to other users'
        ]);
    }

    public function toResponse($request = null, $data)
    {
        return response($data);
    }
}