<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/14/17
 * Time: 5:28 PM
 */
namespace eminent\Activities;

use eminent\Models\Activity;

class ActivityRepository
{

    public function getActivityById($id)
    {
        return Activity::find($id);
    }

    public function store(array $input)
    {
        return Activity::create($input);
    }

    public function updateActivities($activityId, array $input)
    {
        $activity = self::getActivityById($activityId);

        $activity->update($input);

        return $activity;
    }
}