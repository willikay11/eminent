<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/31/17
 * Time: 8:47 PM
 */

namespace App\Http\Controllers;


use Carbon\Carbon;
use eminent\API\SortFilterPaginate;
use eminent\Clients\ClientsRepository;
use eminent\Contacts\ContactsRepository;
use eminent\Interactions\InteractionsRepository;
use eminent\Models\Interaction;
use eminent\UserClients\UserClientsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InteractionController extends Controller
{

    use SortFilterPaginate;

    protected $contactsRepository;
    protected $clientsRepository;
    protected $userClientsRepository;
    protected $interactionsRepository;

    public function __construct(ContactsRepository $contactsRepository,
                                ClientsRepository $clientsRepository,
                                UserClientsRepository $userClientsRepository, InteractionsRepository $interactionsRepository)
    {
        $this->contactsRepository = $contactsRepository;
        $this->clientsRepository = $clientsRepository;
        $this->userClientsRepository = $userClientsRepository;
        $this->interactionsRepository = $interactionsRepository;
    }

    public function getInteractions()
    {
        $filter = [
            'column' => 'user_id',
            'sign' => '=',
            'value' => Auth::id()
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

        return self::toResponse(null, $interactions);
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


    public function toResponse($request = null, $data)
    {
        return response($data);
    }
}