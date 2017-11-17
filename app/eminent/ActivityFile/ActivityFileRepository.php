<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/17/17
 * Time: 2:57 PM
 */

namespace eminent\ActivityFile;

use eminent\Models\ActivityFile;

class ActivityFileRepository
{

    public function save(array $input)
    {
        return ActivityFile::create($input);
    }
}