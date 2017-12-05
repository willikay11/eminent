<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 12/4/17
 * Time: 9:04 PM
 */

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/*
 * Check a users permissions either from the cache or retrieve the afresh
 */
function getPermissions()
{
    if(! Session::has('permissionsArray_' . Auth::id()))
    {
        $permissions = array();

        if(Auth::user())
        {
            $user = Auth::user();

            $userHasRoles = $user->userHasRoles;

            foreach ($userHasRoles as $userHasRole)
            {
                $rolePermissions = $userHasRole->role->permissions;

                foreach ($rolePermissions as $rolePermission)
                {
                    $permissions[] = $rolePermission->permission_id;
                }
            }
        }

        Session::put('permissionsArray_' . Auth::id(), array_unique($permissions));
    }
    
    return Session::get('permissionsArray_' . Auth::id());
}


function resetPermissions()
{
    Session::forget('permissionsArray_' . Auth::id());

    $permissions = array();

    $user = Auth::user();

    $userHasRoles = $user->userHasRoles;

    foreach ($userHasRoles as $userHasRole)
    {
        $rolePermissions = $userHasRole->role->permissions;

        foreach ($rolePermissions as $rolePermission)
        {
            $permissions[] = $rolePermission->permission_id;
        }
    }

    Session::put('permissionsArray_' . Auth::user()->id, array_unique($permissions));
}

function getAdmins()
{
    return explode(',', getenv('ADMIN_EMAIL'));
}