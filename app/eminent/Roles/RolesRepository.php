<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/24/17
 * Time: 11:54 AM
 */
namespace eminent\Roles;

use eminent\Models\Role;

class RolesRepository
{

    public function createRole(array $input)
    {
        return Role::create($input);
    }
}