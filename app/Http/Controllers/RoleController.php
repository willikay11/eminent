<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/23/17
 * Time: 9:33 PM
 */

namespace App\Http\Controllers;

use eminent\API\SortFilterPaginate;
use eminent\Models\Role;
use eminent\Roles\RoleRules;
use eminent\Roles\RolesRepository;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    use RoleRules;

    use SortFilterPaginate;

    protected $rolesRepository;

    public function __construct(RolesRepository $rolesRepository)
    {
        $this->rolesRepository = $rolesRepository;
    }

    public function getAllRoles()
    {
        $roles = $this->sortFilterPaginate(new Role(), [], function ($role)
        {
            return[
                'id' => $role->id,
                'name' => $role->name,
                'description' => $role->description,
            ];
        },null, null);

        return self::toResponse(null, $roles);
    }

    public function index()
    {
        return view('roles.index');
    }

    public function store(Request $request)
    {
        $validation = $this->validateRoleCreate($request);

        if($validation){

            $response = [
                'success' => false,
                'message' => 'Validation failed'
            ];

            return self::toResponse(null, $response);
        }

        $role = $this->rolesRepository->createRole($request->toArray());

        if($role)
        {
            $response = [
                'success' => true,
                'message' => 'Role created successfully'
            ];

            return self::toResponse(null, $response);
        }

        $response = [
            'success' => false,
            'message' => 'Ooops! An error occurred',
        ];

        return self::toResponse(null, $response);
    }

    public function toResponse($request = null, $data)
    {
        return response($data);
    }
}