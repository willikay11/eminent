<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/8/17
 * Time: 8:06 PM
 */

namespace App\Http\Controllers;


use App\Events\Activities\TaskAssigned;
use App\Events\Activities\TaskCommentPosted;
use App\Events\Activities\TaskProgressUpdated;
use App\Events\Activities\TaskStatusUpdated;
use Carbon\Carbon;
use eminent\Activities\ActivityRepository;
use eminent\ActivityFile\ActivityFileRepository;
use eminent\ActivityWatcher\ActivityWatcherRepository;
use eminent\Comments\CommentsRepository;
use eminent\EventReminders\EventRemindersRepository;
use eminent\Events\EventsRepository;
use eminent\Models\Activity;
use eminent\Models\ActivityType;
use eminent\Models\ActivityWatcher;
use eminent\Models\PriorityType;
use eminent\Models\ProgressUpdateStatus;
use eminent\Models\UserClient;
use eminent\ProgressUpdates\ProgressUpdateRepository;
use eminent\ProjectUpdateFiles\ProjectUpdateFilesRepository;
use eminent\Users\UsersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

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
    /**
     * @var CommentsRepository
     */
    private $commentsRepository;
    /**
     * @var ActivityFileRepository
     */
    private $activityFileRepository;
    /**
     * @var ActivityWatcherRepository
     */
    private $activityWatcherRepository;
    /**
     * @var ProgressUpdateRepository
     */
    private $progressUpdateRepository;
    /**
     * @var ProjectUpdateFilesRepository
     */
    private $projectUpdateFilesRepository;
    /**
     * @var EventsRepository
     */
    private $eventsRepository;
    /**
     * @var EventRemindersRepository
     */
    private $eventRemindersRepository;


    public function __construct(UsersRepository $usersRepository,
                                ActivityRepository $activityRepository,
                                CommentsRepository $commentsRepository,
                                ActivityFileRepository $activityFileRepository,
                                ActivityWatcherRepository $activityWatcherRepository,
                                ProgressUpdateRepository $progressUpdateRepository,
                                ProjectUpdateFilesRepository $projectUpdateFilesRepository,
                                EventsRepository $eventsRepository,
                                EventRemindersRepository $eventRemindersRepository)
    {

        $this->usersRepository = $usersRepository;
        $this->activityRepository = $activityRepository;
        $this->commentsRepository = $commentsRepository;
        $this->activityFileRepository = $activityFileRepository;
        $this->activityWatcherRepository = $activityWatcherRepository;
        $this->progressUpdateRepository = $progressUpdateRepository;
        $this->projectUpdateFilesRepository = $projectUpdateFilesRepository;
        $this->eventsRepository = $eventsRepository;
        $this->eventRemindersRepository = $eventRemindersRepository;
    }

    public function index($userId = null)
    {
        if (is_null($userId))
        {
            $user = $this->usersRepository->getUserById(Auth::id());
        }
        else
        {
            $user = $this->usersRepository->getUserById($userId);
        }

        return view('activities.index', [
            'user' => $user
        ]);
    }

    public function viewActivity($id)
    {
        return view('activities.individualActivity', [
            'activityId' => $id
        ]);
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

        $progressUpdateStatuses = ProgressUpdateStatus::all()
            ->map(function ($progressUpdateStatus)
            {
                return [
                    'label' => $progressUpdateStatus->name,
                    'value' => $progressUpdateStatus->id
                ];
            });

        $activityTypes = ActivityType::all()
            ->map(function ($activityType)
            {
                return [
                    'label' => $activityType->name,
                    'value' => $activityType->id
                ];
            });

        $userClients = UserClient::where('user_id', Auth::id())->get()->map(function ($userClient)
        {
            $client = $userClient->client;

            return[
                'label' => $client->contact->present()->fullName,
                'value' => $client->id
            ];
        });

        return self::toResponse(null, [
            'users' => $users,
            'priorities' => $priorities,
            'progressUpdateStatuses' => $progressUpdateStatuses,
            'activityTypes' => $activityTypes,
            'userClients' => $userClients
        ]);

    }

    public function save(Request $request)
    {
        $input = [
            'activity_id' => $request->get('activity_id'),
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'user_id' => $request->get('user_id'),
            'priority_type_id' => $request->get('priority_type_id'),
            'due_date' => Carbon::parse($request->get('due_date'))->endOfDay()->toDateString(),
            'activity_status_id' => $request->get('activity_status_id'),
            'created_by' => Auth::id(),
            'activity_type_id' => $request->get('activity_type_id'),
        ];

        if($request->get('activity_type_id') == 2)
        {
            $input['user_client_id'] = $request->get('user_client_id');
            $input['projected_revenue'] = $request->get('projected_revenue');
        }

        $activity = $this->activityRepository->store($input);

        if ($activity)
        {
            if(is_null($input['activity_id']))
            {
                if ($request->get('user_id') != Auth::id())
                {
                    $input = [
                        'activity_id' => $activity->id,
                        'user_id' => Auth::id()
                    ];

                    $this->activityWatcherRepository->create($input);

                    $input = [
                        'activity_id' => $activity->id,
                        'user_id' => $request->get('user_id')
                    ];

                    $this->activityWatcherRepository->create($input);
                }
                else
                {
                    $input = [
                        'activity_id' => $activity->id,
                        'user_id' => Auth::id()
                    ];

                    $this->activityWatcherRepository->create($input);
                }

                if (Carbon::parse($request->get('due_date'))->endOfDay()->diffInDays(Carbon::now()) > 1)
                {
                    $twentyFourHourEvent =  $this->eventsRepository->save24HourTaskEvent($activity);

                    $this->eventRemindersRepository->saveEventReminder($twentyFourHourEvent);
                }

                if (Carbon::parse($request->get('due_date'))->endOfDay()->diffInDays(Carbon::now()) > 2)
                {
                    $fortyEightHourEvent =  $this->eventsRepository->save48HourTaskEvent($activity);

                    $this->eventRemindersRepository->saveEventReminder($fortyEightHourEvent);
                }

                event(new TaskAssigned($activity));

                return self::toResponse(null, [
                    'success' => true,
                    'message' => 'Task added successfully'
                ]);
            }
            else
            {
                return self::toResponse(null, [
                    'success' => true,
                    'message' => 'Task updated successfully'
                ]);
            }
        }

        return self::toResponse(null, [
            'success' => false,
            'message' => 'Task not added'
        ]);
    }

    public function storeProgressUpdate(Request $request)
    {
        $input = [
            'name' => 'Progress Update as at '.Carbon::now()->toDateTimeString(),
            'description' => $request->get('description'),
            'percentage' => $request->get('percentage'),
            'activity_id' => $request->get('activity_id'),
            'progress_update_status_id' => $request->get('status'),
            'user_id' => Auth::id()
        ];

        $progressUpdate = $this->progressUpdateRepository->create($input);

        if (!is_null($request->file('file')))
        {
            $file = $request->file('file');

            if ($file->isValid()) {

                $fileName = $file->getClientOriginalName();

                $fileExtension = $file->getClientMimeType();

                $filePath = Storage::putFile('/uploads/progress/updates', $file);

                $fileInput = [
                    'progress_update_id' => $progressUpdate->id,
                    'name' => $fileName,
                    'extension' => $fileExtension,
                    'path' => '/storage/'.$filePath
                ];

                $this->projectUpdateFilesRepository->save($fileInput);
            }
        }

        if ($progressUpdate)
        {
            event(new TaskProgressUpdated($progressUpdate));

            return  self::toResponse(null, [
                'success' => true,
                'message' => 'Progress update added successfully'
            ]);
        }

        return self::toResponse(null, [
            'success' => false,
            'message' => 'Oops! Progress update not added'
        ]);

    }

    public function getProgressUpdate($activityId)
    {
        $progressUpdates = $this->progressUpdateRepository->getProgressUpdatesByActivityId($activityId);

        $progressUpdates = $progressUpdates->map(function ($progressUpdate)
        {
            return [
                'name' => $progressUpdate->name,
                'description' => $progressUpdate->description,
                'percentage' => $progressUpdate->percentage,
                'progress_update_status_id' => $progressUpdate->progress_update_status_id,
                'progress_files' => $this->getFile($progressUpdate->progressUpdateFiles)
            ];
        });

        return self::toResponse(null, [
            'success' => true,
            'progressUpdates' => $progressUpdates
        ]);
    }


    public function updateActivityStatus(Request $request)
    {
        $activity = $this->activityRepository->updateActivities($request->get('activity_id'), $request->all());

        if($activity)
        {
            event(new TaskStatusUpdated($activity));

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

    public function getActivities($userId)
    {
        $activities = Activity::where('user_id', $userId)->get()->map(function ($activity)
        {
            return [
                'id' => $activity->id,
                'name' => $activity->name,
                'description' => $activity->description,
                'priority_type_id' => $activity->priority_type_id,
                'priority_type' => $activity->priorityType->name,
                'activity_status_id' => $activity->activity_status_id,
                'activity_status' => $activity->activityStatus->name,
                'due_date' => $activity->due_date,
                'user_id' => $activity->user_id,
                'comments' => $this->getActivityComments($activity->id),
                'watchers' => $this->getActivityWatchers($activity->id),
                'isWatcher' => ($this->activityWatcherRepository->getActivityWatcherByUserIdAndActivityId(Auth::id(), $activity->id) != null)?true:false,
                'countProgressUpdates' =>$activity->progressUpdates->count(),
                'percentage' => ($activity->progressUpdates->last())?$activity->progressUpdates->last()->percentage:0
            ];
        })->groupBy('activity_status');

        return self::toResponse(null, $activities);
    }

    public function getActivity($activityId)
    {
        $activity = $this->activityRepository->getActivityById($activityId);

        $activityData = [
            'id' => $activity->id,
            'name' => $activity->name,
            'description' => $activity->description,
            'priority_type_id' => $activity->priority_type_id,
            'priority_type' => $activity->priorityType->name,
            'activity_status_id' => $activity->activity_status_id,
            'activity_status' => $activity->activityStatus->name,
            'due_date' => $activity->due_date,
            'user_client_id' => $activity->user_client_id,
            'activity_type_id' => $activity->activity_type_id,
            'user_id' => $activity->user_id,
            'projected_revenue' => $activity->projected_revenue,
            'isWatcher' => ($this->activityWatcherRepository->getActivityWatcherByUserIdAndActivityId(Auth::id(), $activity->id) != null)?true:false,
            'start_date' => Carbon::parse($activity->created_at)->format('m/d/Y'),
            'calendar_end_date' => Carbon::parse($activity->due_date)->format('m/d/Y'),
            'today' => Carbon::today()->format('m/d/Y')
        ];

        $comments = $this->getActivityComments($activityId);

        $watchers = $this->getActivityWatchers($activityId);

        $progressUpdates = $this->progressUpdateRepository->getProgressUpdatesByActivityId($activityId);

        $progressUpdates = $progressUpdates->map(function ($progressUpdate)
        {
            return [
                'name' => $progressUpdate->name,
                'description' => $progressUpdate->description,
                'percentage' => $progressUpdate->percentage,
                'progress_update_status_id' => $progressUpdate->progress_update_status_id,
                'progress_files' => $this->getFile($progressUpdate->progressUpdateFiles)
            ];
        });

        $progressUpdateStatuses = ProgressUpdateStatus::all()
            ->map(function ($progressUpdateStatus)
            {
                return [
                    'label' => $progressUpdateStatus->name,
                    'value' => $progressUpdateStatus->id
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

        $activityTypes = ActivityType::all()
            ->map(function ($activityType)
            {
                return [
                    'label' => $activityType->name,
                    'value' => $activityType->id
                ];
            });

        $userClients = UserClient::where('user_id', Auth::id())->get()->map(function ($userClient)
        {
            $client = $userClient->client;

            return[
                'label' => $client->contact->present()->fullName,
                'value' => $client->id
            ];
        });

        return self::toResponse(null, [
            'activity' => $activityData,
            'comments' => $comments,
            'watchers' => $watchers,
            'progressUpdate' => $progressUpdates,
            'progressUpdateStatuses' => $progressUpdateStatuses,
            'priorityTypes' => $priorities,
            'activityTypes' => $activityTypes,
            'userClients' => $userClients
        ]);
    }

    public function search(Request $request)
    {
        $startDate = $request->get('startDate');

        $endDate = $request->get('endDate');

        $priority = $request->get('priority');

        $userId = $request->get('userId');

        $q = Activity::where('user_id', $userId);

        if (!is_null($startDate) && $startDate != '')
        {
            $q->where('due_date', '>=', Carbon::parse($startDate));
        }

        if (!is_null($endDate) && $endDate != '')
        {
            $q->where('due_date', '<=', Carbon::parse($endDate));
        }

        if (!is_null($priority) && $priority != '')
        {
            $q->where('priority_type_id', $priority);
        }

        $activities = $q->get()->map(function ($activity)
        {
            return [
                'id' => $activity->id,
                'name' => $activity->name,
                'description' => $activity->description,
                'priority_type_id' => $activity->priority_type_id,
                'priority_type' => $activity->priorityType->name,
                'activity_status_id' => $activity->activity_status_id,
                'activity_status' => $activity->activityStatus->name,
                'due_date' => $activity->due_date,
                'user_id' => $activity->user_id,
                'comments' => $this->getActivityComments($activity->id),
                'watchers' => $this->getActivityWatchers($activity->id),
                'isWatcher' => ($this->activityWatcherRepository->getActivityWatcherByUserIdAndActivityId(Auth::id(), $activity->id) != null)?true:false,
                'countProgressUpdates' =>$activity->progressUpdates->count(),
                'percentage' => ($activity->progressUpdates->last())?$activity->progressUpdates->last()->percentage:0
            ];
        })->groupBy('activity_status');

        return self::toResponse(null, [
            'success' => true,
            'activities' => $activities,
            'message' => 'Search Completed'
        ]);
    }

    public function getActivityComments($activityId)
    {
        $comments = $this->commentsRepository->getCommentByActivityId($activityId);

        return $comments->map(function ($comment)
        {
            return[
                'comment' => $comment->comment,
                'user_id' => $comment->user_id,
                'username' => $comment->user->present()->fullName,
                'time' => Carbon::parse($comment->created_at)->format('l jS F Y, h:i A'),
                'avatar' => '../../images/avatar_circle_blue.png',
                'files' => $this->getFile($comment->files)
            ];
        });
    }

    public function getFile($files)
    {
        return $files->map(function ($file)
        {
            return [
                'image' => (strpos($file->extension, 'image') !== false)?true:false,
                'name' => $file->name,
                'path' => $file->path
            ];
        });
    }

    public function getActivityWatchers($activityId)
    {
        $activityWatchers = $this->activityWatcherRepository->getActivityWatchersByActivityId($activityId);

        return $activityWatchers->map(function ($activityWatcher)
        {
            return [
                'name' => $activityWatcher->user->contact->present()->fullName,
                'initials' => strtoupper($activityWatcher->user->contact->firstname[0]."".$activityWatcher->user->contact->lastname[0])
            ];
        });
    }

    public function createComment(Request $request)
    {
        $input = $request->all();

        $input['user_id'] = Auth::id();

        $comment = $this->commentsRepository->store($input);

        if (!is_null($request->file('file')))
        {
            if ($request->file('file')->isValid()) {

                $file = $request->file('file');

                $fileName = $file->getClientOriginalName();

                $fileExtension = $file->getClientMimeType();

                $filePath = Storage::putFile('/uploads/activities', $file);

                $fileInput = [
                    'comment_id' => $comment->id,
                    'name' => $fileName,
                    'extension' => $fileExtension,
                    'path' => '/storage/'.$filePath
                ];

                $this->activityFileRepository->save($fileInput);
            }
        }

        if($comment)
        {
            $uploadedComment = [
                'comment' => $comment->comment,
                'user_id' => $comment->user_id,
                'username' => $comment->user->present()->fullName,
                'time' => Carbon::parse($comment->created_at)->format('l jS F Y, h:i A'),
                'avatar' => '../../images/avatar_circle_blue.png',
                'files' => $this->getFile($comment->files)
            ];

            event(new TaskCommentPosted($comment));
            
            return self::toResponse(null, [
                'success' => true,
                'message' => 'Comment posted',
                'uploadedComment' => $uploadedComment
            ]);
        }

        return self::toResponse(null, [
            'success' => false,
            'message' => 'Comment not posted'
        ]);
    }

    public function watchActivity(Request $request)
    {
        $message = null;
        $isWatcher = null;

        if ($request->get('watch'))
        {
            $input = [
                'activity_id' => $request->get('activity_id'),
                'user_id' => Auth::id()
            ];

            $activityWatcher = $this->activityWatcherRepository->create($input);

            if($activityWatcher)
            {
                $message = 'Watching task';
                $isWatcher = true;
            }
        }else
        {
            $activityWatcher = $this->activityWatcherRepository->removeWatcher(Auth::id(), $request->get('activity_id'));

            if($activityWatcher)
            {
                $message = 'Stopped watching task';
                $isWatcher = false;
            }
        }

        if (!is_null($message))
        {
            return self::toResponse(null,[
                'success' => true,
                'message' => $message,
                'isWatcher' => $isWatcher,
                'watchers' => $this->getActivityWatchers($request->get('activity_id'))
            ]);
        }

        return self::toResponse(null,[
            'success' => false,
            'message' => 'Oops! An error occurred'
        ]);
    }

    public function toResponse($request = null, $data)
    {
        return response($data);
    }
}