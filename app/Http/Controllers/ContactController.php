<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/29/17
 * Time: 9:54 AM
 */

namespace App\Http\Controllers;


use eminent\API\SortFilterPaginate;
use eminent\Clients\ClientsRepository;
use eminent\Contacts\ContactRules;
use eminent\Contacts\ContactsRepository;
use eminent\Models\Contact;
use eminent\Models\Country;
use eminent\Models\Gender;
use eminent\Models\Product;
use eminent\Models\Profession;
use eminent\Models\Religions;
use eminent\Models\Sources;
use eminent\Models\Status;
use eminent\Models\Title;
use eminent\UserClients\UserClientsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{

    use ContactRules;

    use SortFilterPaginate;

    protected $contactsRepository;
    protected $clientsRepository;
    protected $userClientsRepository;

    public function __construct(ContactsRepository $contactsRepository,
                                ClientsRepository $clientsRepository,
                                UserClientsRepository $userClientsRepository)
    {
        $this->contactsRepository = $contactsRepository;
        $this->clientsRepository = $clientsRepository;
        $this->userClientsRepository = $userClientsRepository;
    }

    public function getInfo()
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

        $products = Product::where('active', 1)->get();

        $products = $products->map(function ($product)
        {
            return [
                'value' => $product->id,
                'label' => $product->name
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


        $data = [
            'sources' => $sources,
            'titles' => $titles,
            'countries' => $countries,
            'products' => $products,
            'genders' => $genders,
            'professions' => $professions,
            'religions' => $religions
        ];

        return self::toResponse(null, $data);
    }

    public function getUserClients()
    {
        $filterFunc = function ($q)
        {
            return $q->whereHas('clients', function ($q)
            {
                $q->whereHas('userClient', function ($q)
                {
                    $q->where('user_id', Auth::id());
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

        return $this->toResponse(null, $contacts);
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

        $data = [
            'contact' => $contact,
            'statuses' => $statuses
        ];

        return $this->toResponse(null, $data);
    }

    public function index()
    {
        return view('contacts.index');
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

    public function toResponse($request = null, $data)
    {
        return response($data);
    }
}