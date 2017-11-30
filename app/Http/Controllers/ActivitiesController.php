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
use App\Events\Activities\TaskStatusUpdated;
use Carbon\Carbon;
use eminent\Activities\ActivityRepository;
use eminent\ActivityFile\ActivityFileRepository;
use eminent\ActivityWatcher\ActivityWatcherRepository;
use eminent\Comments\CommentsRepository;
use eminent\Models\Activity;
use eminent\Models\ActivityWatcher;
use eminent\Models\PriorityType;
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


    public function __construct(UsersRepository $usersRepository,
                                ActivityRepository $activityRepository,
                                CommentsRepository $commentsRepository,
                                ActivityFileRepository $activityFileRepository,
                                ActivityWatcherRepository $activityWatcherRepository,
                                ProgressUpdateRepository $progressUpdateRepository,
                                ProjectUpdateFilesRepository $projectUpdateFilesRepository)
    {

        $this->usersRepository = $usersRepository;
        $this->activityRepository = $activityRepository;
        $this->commentsRepository = $commentsRepository;
        $this->activityFileRepository = $activityFileRepository;
        $this->activityWatcherRepository = $activityWatcherRepository;
        $this->progressUpdateRepository = $progressUpdateRepository;
        $this->projectUpdateFilesRepository = $projectUpdateFilesRepository;
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
            'created_by' => Auth::id()
        ];

        $activity = $this->activityRepository->store($input);

        if ($activity)
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

            event(new TaskAssigned($activity));

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


    public function storeProgressUpdate(Request $request)
    {
        $input = [
            'name' => 'Progress Update as at '.Carbon::now()->toDateTimeString(),
            'description' => $request->get('description'),
            'percentage' => $request->get('percentage'),
            'activity_id' => $request->get('activity_id'),
            'progress_update_status_id' => 1
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
                'isWatcher' => ($this->activityWatcherRepository->getActivityWatcherByUserIdAndActivityId(Auth::id(), $activity->id) != null)?true:false
            ];
        })->groupBy('activity_status');

        return self::toResponse(null, $activities);
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
                'isWatcher' => ($this->activityWatcherRepository->getActivityWatcherByUserIdAndActivityId(Auth::id(), $activity->id) != null)?true:false
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
                'files' => $this->getCommentFile($comment->files)
            ];
        });
    }

    public function getCommentFile($files)
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
                'name' => $activityWatcher->user->contact->present()->fullName
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
                'files' => $this->getCommentFile($comment->files)
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