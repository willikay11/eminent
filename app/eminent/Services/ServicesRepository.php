<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/2/17
 * Time: 7:16 PM
 */

namespace eminent\Services;


use eminent\Models\Service;

class ServicesRepository
{
    public function getServiceById($id)
    {
        return Service::find($id);
    }

    public function createService(array $input)
    {
        return Service::create($input);
    }

    public function updateService(array $input)
    {
        $service = $this->getServiceById($input['serviceId']);

        return $service->update($input);
    }
}