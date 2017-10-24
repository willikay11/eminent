<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/24/17
 * Time: 11:55 AM
 */

namespace eminent\Roles;


use eminent\Rules\Rules;

trait RoleRules
{

    use Rules;

    public function validateRoleCreate($request)
    {
        $rules = [
            'name' => 'required | unique:roles',
            'description' => 'required'
        ];

        return $this->verdict($request, $rules);
    }
}