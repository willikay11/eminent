<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/8/17
 * Time: 8:06 PM
 */

namespace App\Http\Controllers;


use Carbon\Carbon;
use eminent\Models\Activity;
use eminent\Models\PriorityType;
use eminent\Users\UsersRepository;
use Illuminate\Http\Request;

class ActivitiesController extends Controller
{

    /**
     * @var UsersRepository
     */
    private $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {

        $this->usersRepository = $usersRepository;
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
        Activity::create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'user_id' => $request->get('user_id'),
            'priority_type_id' => $request->get('priority_type_id'),
            'due_date' => Carbon::parse($request->get('due_date'))->toDateString(),
            'activity_status_id' => $request->get('activity_status_id'),
        ]);

        return self::toResponse(null, [
            'success' => true,
            'message' => 'Task added successfully'
        ]);
    }

    public function getActivities()
    {
        $activities = Activity::all()->map(function ($activity)
        {
            return [
                'name' => $activity->name,
                'description' => $activity->description,
                'priority_type_id' => $activity->priority_type_id,
                'priority_type' => $activity->priorityType->name,
                'activity_status_id' => $activity->activity_status_id,
                'activity_status' => $activity->activityStatus->name,
                'due_date' => $activity->due_date
            ];
        });

        return self::toResponse(null, $activities);
    }

    public function toResponse($request = null, $data)
    {
        return response($data);
    }
}