<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/29/17
 * Time: 9:35 AM
 */
namespace eminent\Departments;
use eminent\Models\Department;

class DepartmentsRepository
{

    public function getDepartmentById($id)
    {
        return Department::find($id);
    }

    public function createDepartment(array $input)
    {
        return Department::create($input);
    }

    public function updateDepartment(array $input)
    {
        $department = $this->getDepartmentById($input['departmentId']);

        return $department->update($input);
    }

}