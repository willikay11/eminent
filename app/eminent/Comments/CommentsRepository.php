<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/14/17
 * Time: 9:23 PM
 */
namespace eminent\Comments;

use eminent\Models\Comment;

class CommentsRepository
{

    public function getCommentById($id)
    {
        return Comment::find($id);
    }

    public function getCommentByActivityId($activityId)
    {
        return Comment::where('activity_id', $activityId)->get();
    }

    public function store(array $input)
    {
        return Comment::create($input);
    }
}