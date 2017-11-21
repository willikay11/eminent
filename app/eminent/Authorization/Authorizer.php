<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/20/17
 * Time: 7:57 PM
 */

namespace eminent\Authorization;

use eminent\Exceptions\AuthorizationFailedException;
use eminent\Models\Permission;
use eminent\Models\RolePermission;
use eminent\Models\UserHasRole;
use Illuminate\Support\Facades\Auth;

trait Authorizer
{

    /*
    * Check if user has this permission
    */
    public function hasPermission($permissionName, $isApi = false)
    {
        $permission = Permission::where('name', $permissionName)->first();

        if (!$this->userRolesHavePermission($permission)) {

            if ($isApi) {
                return $response = [
                    'success' => false,
                    'message' => "Access Denied: You cannot " . strtolower($permission->description),
                ];
            }

            throw new AuthorizationFailedException($permission->description);
        }

        return true;
    }

    public function userRolesHavePermission($permission)
    {
        $user_roles = UserHasRole::where('user_id', Auth::user()->id)->get();

        foreach ($user_roles as $user_role) {
            if ($this->roleHasPermission($user_role, $permission)) {
                return true;
            }
        }

        return false;
    }

    public function roleHasPermission($user_role, $permission)
    {
        $role_permission = RolePermission::where('role_id', $user_role->role_id)->where('permission_id', $permission->id)->first();

        if ($role_permission) {
            return true;
        }

        return false;
    }
}