<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/29/17
 * Time: 9:34 AM
 */

namespace App\Http\Controllers;


use eminent\API\SortFilterPaginate;
use eminent\Departments\DepartmentsRepository;
use eminent\Departments\DepartmentsRules;
use eminent\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    use SortFilterPaginate;
    use DepartmentsRules;

    protected $departmentsRepository;

    public function __construct(DepartmentsRepository $departmentsRepository)
    {
        $this->departmentsRepository = $departmentsRepository;
    }

    public function getDepartments()
    {
        $departments = $this->sortFilterPaginate(new Department(), [], function ($department)
        {
            return[
                'id' => $department->id,
                'name' => $department->name,
                'active' => $department->present()->activeStatus
            ];
        },null, null);

        return self::toResponse(null, $departments);
    }

    public function index()
    {
        return view('departments.index');
    }

    public function store(Request $request)
    {
        if(is_null($request->get('departmentId')))
        {
            return $this->save($request);
        }

        return $this->edit($request);

    }

    public function save($request)
    {
        $validation = $this->validateDepartmentCreate($request);

        if($validation)
        {
            $response = [
                'success' => false,
                'message' => 'Validation failed'
            ];

            return $response;
        }

        $department = $this->departmentsRepository->createDepartment($request->toArray());

        if($department)
        {
            $response = [
                'success' => true,
                'message' => 'Departmet added successfully'
            ];

            return $response;
        }

        $response = [
            'success' => false,
            'message' => 'Oops! An error occurred'
        ];

        return $response;
    }

    public function edit($request)
    {
        $validation = $this->validateDepartmentEdit($request);

        if($validation)
        {
            $response = [
                'success' => false,
                'message' => 'Validation failed'
            ];

            return $response;
        }

        $department = $this->departmentsRepository->updateDepartment($request->toArray());

        if($department)
        {
            $response = [
                'success' => true,
                'message' => 'Department edited successfully'
            ];

            return $response;
        }

        $response = [
            'success' => false,
            'message' => 'Oops! An error occurred'
        ];

        return $response;
    }

    public function toResponse($request = null, $data)
    {
        return response($data);
    }
}