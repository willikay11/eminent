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
use eminent\Models\UserHasRole;
use eminent\Roles\RoleRules;
use eminent\Roles\RolesRepository;
use eminent\UserHasRoles\UserHasRolesRepository;
use eminent\Users\UsersRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class RoleController extends Controller
{
    use RoleRules;

    use SortFilterPaginate;

    protected $rolesRepository;

    protected $usersRepository;
    /**
     * @var UserHasRolesRepository
     */
    private $userHasRolesRepository;

    public function __construct(RolesRepository $rolesRepository,
                                UsersRepository $usersRepository, UserHasRolesRepository $userHasRolesRepository)
    {
        $this->rolesRepository = $rolesRepository;
        $this->usersRepository = $usersRepository;
        $this->userHasRolesRepository = $userHasRolesRepository;
    }

    public function getAllRoles()
    {
        $roles = $this->sortFilterPaginate(new Role(), [], function ($role)
        {
            return[
                'id' => $role->id,
                'name' => $role->name,
                'description' => $role->description,
                'active' => $role->present()->activeStatus,
            ];
        },null, null);

        return self::toResponse(null, $roles);
    }

    public function getMembers($roleId)
    {
        $userHasRoles = UserHasRole::where('role_id', $roleId)->get();

        $users = array();

        foreach ($userHasRoles as $userHasRole)
        {
            $user = $userHasRole->user;

            $users[] = [
                'id' => $user->id,
                'name' => $user->contact->firstname.' '.$user->contact->lastname,
                'email' => $user->email,
            ];

        }

//        $users = $this->sortFilterPaginate(new User(), [$filter], function ($user)
//        {
//            return[
//                'id' => $user->id,
//                'name' => $user->contact->firstname.' '.$user->contact->lastname,
//                'email' => $user->email,
//            ];
//        },null, null);

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

    public function getUserRoles($userId)
    {
        $user = $this->usersRepository->getUserById($userId);

        $userRoles = UserHasRole::where('user_id', $userId)->get();

        if(count($userRoles))
        {

            $roles = $userRoles->map(function ($userRole)
            {
                $role = $userRole->role;

                return[
                    'id' => $role->id,
                    'name' => $role->name,
                    'description' => $role->description
                ];
            });

            return self::toResponse(null, [
                'success' => true,
                'username' => $user->present()->fullName,
                'data' => $roles
            ]);
        }

        return self::toResponse(null, [
            'success' => false,
            'username' => $user->present()->fullName,
            'message' => 'User has no roles',
            'data' => []
        ]);
    }

    public function userRoles($userId)
    {
        $user = $this->usersRepository->getUserById($userId);

        $roles = $this->rolesRepository->getAllRoles()->where('active', 1);

        $userRoles = $this->userHasRolesRepository->getUserRoleByUserId($userId)->pluck('role_id');;

        return view('users.addRole', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles
        ]);
    }

    public function updateUserRoles($userId, Request $request)
    {
        $roles = $request->except(['_token']);

        $userRoles = $this->userHasRolesRepository->getUserRoleByUserId($userId);

        foreach($userRoles as $userRole)
        {
            $userRole->delete();
        }

        $this->userHasRolesRepository->updateUserRoles($userId, $roles);

        return redirect('/user/'.$userId.'/roles');
    }

    public function revokeRoleFromUser($roleId, $userId)
    {
        $userHasRole = $this->userHasRolesRepository->deleteUserRole($userId, $roleId);

        if ($userHasRole)
        {
            return self::toResponse(null, [
                'success' => true,
                'message' => 'User Role has been revoked'
            ]);
        }

        return self::toResponse(null, [
            'success' => false,
            'message' => 'Oops! An error occurred'
        ]);
    }

    public function toResponse($request = null, $data)
    {
        return response($data);
    }
}