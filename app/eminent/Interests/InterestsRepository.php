<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/2/17
 * Time: 8:06 PM
 */

namespace eminent\Interests;

use eminent\Models\Interest;

class InterestsRepository
{
    public function save($serviceId, $clientId)
    {
        return Interest::create([
            'client_id' => $clientId,
            'service_id' => $serviceId
        ]);
    }
}