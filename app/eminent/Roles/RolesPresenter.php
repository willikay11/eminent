<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/29/17
 * Time: 8:37 AM
 */

namespace eminent\Roles;


use Laracasts\Presenter\Presenter;

class RolesPresenter extends Presenter
{
    public function activeStatus()
    {
        if($this->active == 1)
        {
            return 'Active';
        }
        else
        {
            return "Inactive";
        }
    }
}