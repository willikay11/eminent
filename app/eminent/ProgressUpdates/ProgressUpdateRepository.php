<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/30/17
 * Time: 2:13 PM
 */

namespace eminent\ProgressUpdates;


use eminent\Models\ProgressUpdate;

class ProgressUpdateRepository
{

    public function create(array $input)
    {
        return ProgressUpdate::create($input);
    }

    public function getProgressUpdatesByActivityId($activityId)
    {
        return ProgressUpdate::where('activity_id', $activityId)->orderBy('created_at', 'DESC')->get();
    }
}