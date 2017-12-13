<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/23/17
 * Time: 7:07 PM
 */

namespace App\Http\Controllers;

use eminent\API\SortFilterPaginate;
use eminent\Authorization\Authorizer;
use eminent\Models\Permission;

class PermissionController extends Controller
{
    use Authorizer;

    use SortFilterPaginate;

    public function __construct()
    {

    }

    public function getAllPermissions()
    {
        $permissions = $this->sortFilterPaginate(new Permission(), [], function ($permission)
        {
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
        $this->hasPermission('managePermissions');

        return view('permission.index');
    }



    public function toResponse($request = null, $data)
    {
        return response($data);
    }
}