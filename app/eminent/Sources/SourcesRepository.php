<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/29/17
 * Time: 9:04 AM
 */

namespace eminent\Sources;


use eminent\Models\Sources;

class SourcesRepository
{

    public function getSourceById($id)
    {
        return Sources::find($id);
    }

    public function createSource(array $input)
    {
        return Sources::create($input);
    }

    public function updateSource(array $input)
    {
        $source = $this->getSourceById($input['sourceId']);

        return $source->update($input);
    }
}