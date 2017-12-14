<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 12/14/17
 * Time: 1:05 PM
 */
namespace eminent\UserFeedBack;

use eminent\Models\UserFeedback;

class UserFeedBackRepository
{
    public function store(array $input)
    {
        return UserFeedback::create($input);
    }
}