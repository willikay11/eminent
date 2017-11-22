<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/22/17
 * Time: 2:30 PM
 */

namespace eminent\ActivityWatcher;

use eminent\Models\ActivityWatcher;

class ActivityWatcherRepository
{

    public function create(array $input)
    {
        return ActivityWatcher::create($input);
    }

    public function getActivityWatchersByActivityId($activityId)
    {
        return ActivityWatcher::where('activity_id', $activityId)->get();
    }

    public function getActivityWatcherByUserIdAndActivityId($userId, $activityId)
    {
        return ActivityWatcher::where('activity_id', $activityId)->where('user_id', $userId)->first();
    }

    public function removeWatcher($userId, $activityId)
    {
        return ActivityWatcher::where('activity_id', $activityId)->where('user_id', $userId)->delete();
    }
}