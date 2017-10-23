<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/23/17
 * Time: 8:53 PM
 */

namespace eminent\Permissions;

use eminent\Models\Permission;

class PermissionRepository
{

    public function getAllPermissions()
    {
        return Permission::all();
    }
}