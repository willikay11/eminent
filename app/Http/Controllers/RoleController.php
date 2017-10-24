<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/23/17
 * Time: 9:33 PM
 */

namespace App\Http\Controllers;

use eminent\API\SortFilterPaginate;
use eminent\Models\Permission;
use eminent\Models\Role;
use eminent\Models\RolePermission;
use eminent\Models\User;
use eminent\Roles\RoleRules;
use eminent\Roles\RolesRepository;
use eminent\Users\UsersRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class RoleController extends Controller
{
    use RoleRules;

    use SortFilterPaginate;

    protected $rolesRepository;

    protected $usersRepository;

    public function __construct(RolesRepository $rolesRepository, UsersRepository $usersRepository)
    {
        $this->rolesRepository = $rolesRepository;
        $this->usersRepository = $usersRepository;
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

    public function getMembers($roleId)
    {
        $filter = [
            'column' => 'role_id',
            'sign' => '=',
            'value' =>  $roleId
        ];

        $users = $this->sortFilterPaginate(new User(), [$filter], function ($user)
        {
            return[
                'id' => $user->id,
                'name' => $user->contact->firstname.' '.$user->contact->lastname,
                'email' => $user->email,
            ];
        },null, null);

        return self::toResponse(null, $users);
        
    }

    public function getPermissions($roleId)
    {
        $filter = [
            'column' => 'role_id',
            'sign' => '=',
            'value' =>  $roleId
        ];

        $permissions = $this->sortFilterPaginate(new RolePermission(), [$filter], function ($rolePermission)
        {
            $permission = $rolePermission->permission;

            return[
                'id' => $permission->id,
                'name' => $permission->name,
                'description' => $permission->description,
            ];
        },null, null);

        return self::toResponse(null, $permissions);

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

    public function details($roleId)
    {
        $role = $this->rolesRepository->getRoleById($roleId);

        return view('roles.details', [
            'role' => $role
        ]);
    }

    public function permissions($id)
    {
        $role = $this->rolesRepository->getRoleById($id);

        $permissions = $role->permissions->pluck('permission_id');

        $allPermissions = Permission::all();

        return view('roles.permissions', [
            'permissions' => $allPermissions,
            'role' => $role,
            'role_permissions' => $permissions
        ]);
    }

    public function updatePermissions(Request $request,$id)
    {
        $permissions = $request->except(['_token']);

        $role = $this->rolesRepository->getRoleById($id);

        $rolePermissions = $role->permissions;

        foreach($rolePermissions as $rolePermission)
        {
            $rolePermission->delete();
        }

        $this->rolesRepository->updatePermissions($permissions, $id);

        return redirect('/roles/details/'.$role->id);
    }

    public function revoke($id)
    {
        $this->usersRepository->revoke($id);
    }

    public function permissionRevoke($role, $permission)
    {
        $this->rolesRepository->revokePermission($role, $permission);
    }

    public function toResponse($request = null, $data)
    {
        return response($data);
    }
}