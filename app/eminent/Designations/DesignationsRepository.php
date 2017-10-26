<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/26/17
 * Time: 7:52 AM
 */

namespace eminent\Designations;


use eminent\Models\Designation;

class DesignationsRepository
{

    public function getDesignationById($id)
    {
        return Designation::find($id);
    }

    public function createDesignation(array $input)
    {
        return Designation::create($input);
    }

    public function updateDesignation(array $input)
    {
        $designation = $this->getDesignationById($input['designationId']);

        return $designation->update($input);
    }
}