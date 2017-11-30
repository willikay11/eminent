<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/30/17
 * Time: 2:22 PM
 */
namespace eminent\ProjectUpdateFiles;

use eminent\Models\ProgressUpdateFile;

class ProjectUpdateFilesRepository
{
    public function save(array $input)
    {
        return ProgressUpdateFile::create($input);
    }
}