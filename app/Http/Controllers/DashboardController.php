<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/8/17
 * Time: 5:48 PM
 */

namespace App\Http\Controllers;


use Carbon\Carbon;
use eminent\Activities\ActivityRepository;
use eminent\API\SortFilterPaginate;
use eminent\Authorization\Authorizer;
use eminent\Models\Activity;
use eminent\Models\Contact;
use eminent\Models\Interaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    use SortFilterPaginate;

    use Authorizer;

    /**
     * @var ActivityRepository
     */
    private $activityRepository;

    public function __construct(ActivityRepository $activityRepository)
    {
        $this->activityRepository = $activityRepository;
    }

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

    public function getDashBoardCalendar($userId, $month = null, $year = null)
    {
        $month = (is_null($month) && is_null($year))?Carbon::now():Carbon::createFromDate($year, $month, 1);

        $monthlyTasks = $this->activityRepository->getMonthlyTasks(Carbon::parse($month), $userId);

        $monthlyTasks = $monthlyTasks->map(function ($monthlyTask)
        {
            return [
                'id' => $monthlyTask->id,
                'title' => $monthlyTask->name,
                'date' => Carbon::parse($monthlyTask->due_date)->format('Y/m/d'),
                'formattedDate' => explode(',', Carbon::parse($monthlyTask->due_date)->toFormattedDateString())[0],
                'status' => $monthlyTask->activity_status_id,
                'days' => self::getDaysRemaining(Carbon::parse($monthlyTask->due_date)->endOfDay()),
                'percentage' => ($monthlyTask->progressUpdates->last())?$monthlyTask->progressUpdates->last()->percentage:0
            ];
        });

        return self::toResponse(null, [
            'success' => true,
            'calendar' => $monthlyTasks,
            'message' => 'Calendar loaded'
        ]);
    }

    public function getDaysRemaining(Carbon $date)
    {
        $daysRemaining = Carbon::now()->diffInDays($date);

        if(Carbon::today()->gt($date))
        {
            return [
                'daysRemaining' => $daysRemaining,
                'content' => 'Days ago'
            ];
        }
        elseif (Carbon::today()->eq($date))
        {
            return [
                'daysRemaining' => $daysRemaining,
                'content' => 'Task due today'
            ];
        }
        return [
            'daysRemaining' => $daysRemaining,
            'content' => 'Days to finish'
        ];
    }

    public function cardInfo($userId)
    {
        $activities =  Activity::where('user_id', $userId)->get();

        $data =  [
            'todo' => $activities->where('activity_status_id', 1)->count(),
            'ongoing' => $activities->where('activity_status_id', 2)->count(),
            'review' => $activities->where('activity_status_id', 3)->count(),
            'complete' => $activities->where('activity_status_id', 4)->count(),
        ];

        return self::toResponse(null, [
            'success' => true,
            'data' => $data,
        ]);
    }

    public function toResponse($request = null, $data)
    {
        return response($data);
    }

}