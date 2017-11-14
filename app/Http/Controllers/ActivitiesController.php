<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/8/17
 * Time: 8:06 PM
 */

namespace App\Http\Controllers;


use Carbon\Carbon;
use eminent\Activities\ActivityRepository;
use eminent\Models\Activity;
use eminent\Models\PriorityType;
use eminent\Users\UsersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivitiesController extends Controller
{

    /**
     * @var UsersRepository
     */
    private $usersRepository;
    /**
     * @var ActivityRepository
     */
    private $activityRepository;

    public function __construct(UsersRepository $usersRepository, ActivityRepository $activityRepository)
    {

        $this->usersRepository = $usersRepository;
        $this->activityRepository = $activityRepository;
    }

    public function index()
    {
        return view('activities.index');
    }

    public function getInformation()
    {
        $users = $this->usersRepository
            ->getAllActiveUsers()
            ->map(function ($user)
            {
                return [
                    'label' => $user->contact->present()->fullName,
                    'value' => $user->id
                ];
            });

        $priorities = PriorityType::all()
            ->map(function ($priority)
            {
                return [
                    'label' => $priority->name,
                    'value' => $priority->id
                ];
            });

        return self::toResponse(null, [
            'users' => $users,
            'priorities' => $priorities,
        ]);

    }


    public function save(Request $request)
    {
        $input = [
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'user_id' => $request->get('user_id'),
            'priority_type_id' => $request->get('priority_type_id'),
            'due_date' => Carbon::parse($request->get('due_date'))->toDateString(),
            'activity_status_id' => $request->get('activity_status_id'),
        ];

        $activity = $this->activityRepository->store($input);

        if ($activity)
        {
            return self::toResponse(null, [
                'success' => true,
                'message' => 'Task added successfully'
            ]);
        }

        return self::toResponse(null, [
            'success' => false,
            'message' => 'Task not added'
        ]);
    }


    public function updateActivityStatus(Request $request)
    {
        $activity = $this->activityRepository->updateActivities($request->get('activity_id'), $request->all());

        if($activity)
        {
            return self::toResponse(null, [
                'success' => true,
                'message' => 'Activity Updated successfully'
            ]);
        }
        return self::toResponse(null, [
            'success' => false,
            'message' => 'Activity not updated'
        ]);
    }

    public function getActivities()
    {
        $activities = Activity::where('user_id', Auth::id())->get()->map(function ($activity)
        {
            return [
                'id' => $activity->id,
                'name' => $activity->name,
                'description' => $activity->description,
                'priority_type_id' => $activity->priority_type_id,
                'priority_type' => $activity->priorityType->name,
                'activity_status_id' => $activity->activity_status_id,
                'activity_status' => $activity->activityStatus->name,
                'due_date' => $activity->due_date
            ];
        })->groupBy('activity_status');

        return self::toResponse(null, $activities);
    }

    public function toResponse($request = null, $data)
    {
        return response($data);
    }
}