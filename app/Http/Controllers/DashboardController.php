<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/8/17
 * Time: 5:48 PM
 */

namespace App\Http\Controllers;


use Carbon\Carbon;
use eminent\API\SortFilterPaginate;
use eminent\Authorization\Authorizer;
use eminent\Models\Contact;
use eminent\Models\Interaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    use SortFilterPaginate;

    use Authorizer;

    public function index()
    {
        $userId = Auth::id();

        return view('dashboard.dashboard', [
            'userId' => $userId
        ]);
    }

    public function getDashBoardUserClients($userId)
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
                'organization' => $contact->organization,
            ];
        },$filterFunc, 5);

        return $this->toResponse(null, [
            'success' => true,
            'contacts' => $contacts,
            'messgae' => 'Contacts loaded'
        ]);
    }

    public function getDashBoardInteractions($userId)
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
        },null, 5);

        return self::toResponse(null, [
            'success' => true,
            'interactions' => $interactions,
            'message' => 'Interactions loaded'
        ]);
    }

    public function toResponse($request = null, $data)
    {
        return response($data);
    }

}