<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/31/17
 * Time: 8:47 PM
 */

namespace App\Http\Controllers;


use App\Events\Interactions\exportInteractionsGenerated;
use Carbon\Carbon;
use eminent\API\SortFilterPaginate;
use eminent\Clients\ClientsRepository;
use eminent\Contacts\ContactsRepository;
use eminent\Excel\Excels;
use eminent\Interactions\InteractionsRepository;
use eminent\Models\Interaction;
use eminent\Models\PriorityType;
use eminent\UserClients\UserClientsRepository;
use eminent\Users\UsersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InteractionController extends Controller
{

    use SortFilterPaginate;

    protected $contactsRepository;
    protected $clientsRepository;
    protected $userClientsRepository;
    protected $interactionsRepository;
    protected $usersRepository;

    public function __construct(ContactsRepository $contactsRepository,
                                ClientsRepository $clientsRepository,
                                UserClientsRepository $userClientsRepository,
                                InteractionsRepository $interactionsRepository,
                                UsersRepository $usersRepository)
    {
        $this->contactsRepository = $contactsRepository;
        $this->clientsRepository = $clientsRepository;
        $this->userClientsRepository = $userClientsRepository;
        $this->interactionsRepository = $interactionsRepository;
        $this->usersRepository = $usersRepository;
    }

    public function getInteractions($userId)
    {
        $filter = [
            'column' => 'user_id',
            'sign' => '=',
            'value' => $userId
        ];

        $interactions = $this->sortFilterPaginate(new Interaction(), [$filter], function ($interaction)
        {
            return[
                'id' => $interaction->id,
                'client' => $interaction->client->contact->present()->fullName,
                'interactionType' => $interaction->interactionType->name,
                'date' => Carbon::parse($interaction->interaction_date)->format('jS F Y'),
                'remarks' => $interaction->remarks,
            ];
        },null, null);

        return self::toResponse(null, [
            'success' => true,
            'interactions' => $interactions,
            'message' => 'Interactions loaded'
        ]);
    }

    public function storeSchedule(Request $request)
    {
        $userClient = $this->userClientsRepository->saveScheduledInteraction($request->all());

        if($userClient)
        {
            return self::toResponse(null, [
                'success' => true,
                'message' => 'Schedule added successfully',
                'schedule' => $userClient->next_interaction_date,
            ]);
        }

        return self::toResponse(null, [
            'success' => false,
            'message' => 'Schedule not added'
        ]);
    }

    public function store(Request $request)
    {
        $userClient = $this->userClientsRepository->getUserClientById($request->get('userClientId'));

        $input = $request->all();

        $input['client_id'] = $userClient->client_id;

        $input['interaction_date'] = Carbon::parse($input['interaction_date'])->format('Y-m-d');

        $interaction = $this->interactionsRepository->save($input, null);

        if($request->get('next_interaction_date') != "")
        {
            $this->userClientsRepository->saveScheduledInteraction($request->all());

            if($interaction)
            {
                return self::toResponse(null, [
                    'success' => true,
                    'message' => 'Interaction saved and next interaction scheduled successfully'
                ]);
            }
        }

        if($interaction)
        {
            return self::toResponse(null, [
                'success' => true,
                'message' => 'Interaction added successfully'
            ]);
        }

    }

    public function searchInteractions(Request $request)
    {
        $startDate = $request->get('startDate');

        $endDate = $request->get('endDate');

        $userId = $request->get('userId');

        $filter = array();

        $filter[] = [
            'column' => 'user_id',
            'sign' => '=',
            'value' => $userId
        ];

        if (!is_null($startDate) && $startDate != '')
        {
            $filter[] = [
                'column' => 'interaction_date',
                'sign' => '>=',
                'value' => Carbon::parse($startDate)
            ];
        }

        if (!is_null($endDate) && $endDate != '')
        {
            $filter[] = [
                'column' => 'interaction_date',
                'sign' => '<=',
                'value' => Carbon::parse($endDate)
            ];
        }

        $interactions = $this->sortFilterPaginate(new Interaction(), $filter, function ($interaction)
        {
            return[
                'id' => $interaction->id,
                'client' => $interaction->client->contact->present()->fullName,
                'interactionType' => $interaction->interactionType->name,
                'date' => Carbon::parse($interaction->interaction_date)->format('jS F Y'),
                'remarks' => $interaction->remarks,
            ];
        },null, null);

        return self::toResponse(null, [
            'success' => true,
            'interactions' => $interactions,
            'message' => 'Interactions loaded'
        ]);
    }

    public function exportInteractions(Request $request)
    {
        $startDate = $request->get('startDate');

        $endDate = $request->get('endDate');

        $userId = $request->get('userId');

        $q = Interaction::where('user_id', $userId);

        if (!is_null($startDate) && $startDate != '') {
            $q->where('interaction_date', '>=', Carbon::parse($startDate));

        }

        if (!is_null($endDate) && $endDate != '') {
            $q->where('interaction_date', '<=', Carbon::parse($endDate));
        }

        $interactions = $q->get();

        $interactions = $interactions->map(function ($interaction)
        {
            return [
                'client' => $interaction->client->contact->present()->fullName,
                'interactionType' => $interaction->interactionType->name,
                'date' => Carbon::parse($interaction->interaction_date)->format('jS F Y'),
                'remarks' => $interaction->remarks,
                'user' => $interaction->user->contact->present()->fullName
            ];
        });

        Excels::generateSingleExcelFromViewAndStore($interactions, 'Interactions_report', 'excel.export_interactions');

        $user = $this->usersRepository->getUserById(Auth::id());

        event(new exportInteractionsGenerated('Interactions_report.xlsx', $user));

        return $this->toResponse(null, [
            'success' => true,
            'message' => 'Interactions generated. Please check your email'
        ]);
    }
    public function userInteractions($userId = null)
    {
        if(is_null($userId))
        {
            $userId = Auth::id();
        }

        return view('interactions.index', [
            'userId' => $userId
        ]);
    }

    public function toResponse($request = null, $data)
    {
        return response($data);
    }
}