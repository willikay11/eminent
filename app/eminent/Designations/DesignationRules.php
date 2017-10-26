<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/26/17
 * Time: 7:49 AM
 */
namespace eminent\Designations;

use eminent\Rules\Rules;

trait DesignationRules
{

    use Rules;

    public function validateDesignationCreate($request)
    {
        $rules = [
            'name' => 'required | unique:designations',
            'active' => 'required'
        ];

        return $this->verdict($request, $rules);
    }

    public function validateDesignationEdit($request)
    {
        $rules = [
            'name' => 'required | unique:designations,name,' . $request->get('designationId'),
            'active' => 'required'
        ];

        return $this->verdict($request, $rules);
    }
}