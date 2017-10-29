<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/29/17
 * Time: 9:36 AM
 */

namespace eminent\Departments;


use eminent\Rules\Rules;

trait DepartmentsRules
{
    use Rules;

    public function validateDepartmentCreate($request)
    {
        $rules = [
            'name' => 'required | unique:departments',
            'active' => 'required'
        ];

        return $this->verdict($request, $rules);
    }

    public function validateDepartmentEdit($request)
    {
        $rules = [
            'name' => 'required | unique:departments,name,' . $request->get('departmentId'),
            'active' => 'required'
        ];

        return $this->verdict($request, $rules);
    }
}