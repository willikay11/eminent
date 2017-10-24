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

class RoleController extends Controller
{

    use SortFilterPaginate;

    public function __construct()
    {
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

    public function toResponse($request = null, $data)
    {
        return response($data);
    }
}