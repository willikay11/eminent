<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/14/17
 * Time: 5:28 PM
 */
namespace eminent\Activities;

use Carbon\Carbon;
use eminent\Models\Activity;

class ActivityRepository
{

    public function getActivityById($id)
    {
        return Activity::find($id);
    }

    public function store(array $input)
    {
        if(is_null($input['activity_id']))
        {
            return Activity::create($input);
        }
        else
        {
            $activity = $this->getActivityById($input['activity_id']);

            $activity->update($input);

            return $activity;
        }
    }

    public function updateActivities($activityId, array $input)
    {
        $activity = self::getActivityById($activityId);

        \Log::info($input);

        $activity->update($input);

        return $activity;
    }

    public function getTasksDueToday()
    {
        $today = Carbon::now()->toDateString();

        return Activity::where('due_date', '<=', $today)->where('activity_status_id', '!=', 4)->get();
    }

    public function getMonthlyTasks(Carbon $month, $userId)
    {
        $startOfMonth = Carbon::parse($month)->startOfMonth();

        $endOfMonth = Carbon::parse($month)->endOfMonth();

        return Activity::where('due_date', '>=', $startOfMonth)
            ->where('due_date', '<=', $endOfMonth)
            ->where('user_id', $userId)
            ->orderBy('due_date')
            ->get();
    }
}