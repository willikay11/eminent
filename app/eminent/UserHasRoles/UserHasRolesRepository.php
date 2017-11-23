<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/20/17
 * Time: 9:05 PM
 */
namespace eminent\UserHasRoles;

use eminent\Models\UserHasRole;

class UserHasRolesRepository
{

    public function getUserRoleById($id)
    {
        return UserHasRole::find($id);
    }

    public function create(array $input)
    {
        return UserHasRole::create($input);
    }

    public function getUserRoleByUserId($userId)
    {
        return UserHasRole::where('user_id', $userId)->get();
    }

    public function deleteUserRole($userId, $roleId)
    {
        return UserHasRole::where('user_id', $userId)->where('role_id', $roleId)->delete();
    }

    public function updateUserRoles($userId, $roles)
    {
        foreach(array_keys($roles) as $role)
        {
            UserHasRole::create([
                'user_id' => $userId,
                'role_id' => $role
            ]);
        }
    }

    public function deleteAllUserRoles($userId)
    {
        $userHasRoles = $this->getUserRoleByUserId($userId);

        if(!is_null($userHasRoles))
        {
            $userHasRoles->each(function ($userHasRole)
            {
                $userHasRole->delete();
            });
        }
    }
}