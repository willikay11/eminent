<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/24/17
 * Time: 11:54 AM
 */
namespace eminent\Roles;

use eminent\Models\Role;
use eminent\Models\RolePermission;
use Illuminate\Database\Eloquent\Collection;

class RolesRepository
{

    public function getAllRoles()
    {
        return Role::all();
    }

    public function getRoleById($id)
    {
        return Role::find($id);
    }

    public function createRole(array $input)
    {
        return Role::create($input);
    }

    public function updatePermissions($permissions, $id)
    {
        $role = $this->getRoleById($id);

        $rolePermissions = RolePermission::where('role_id', $role->id)->withTrashed()->get();

        foreach(array_keys($permissions) as $permission)
        {
            if($rolePermissions->contains('permission_id', $permission))
            {
                RolePermission::where('permission_id', $permission)->restore();

            }else{
                RolePermission::create([
                    'role_id' => $role->id,
                    'permission_id' => $permission
                ]);
            }
        }
    }

    public function revokePermission($role, $permission)
    {
        $rolePermissions = RolePermission::where('role_id', $role)->where('permission_id', $permission)->get();

        foreach($rolePermissions as $rolePermission)
        {
            $rolePermission->delete();
        }
    }
}