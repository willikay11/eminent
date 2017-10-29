<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/29/17
 * Time: 9:36 AM
 */

namespace eminent\Departments;


use Laracasts\Presenter\Presenter;

class DepartmentsPresenter extends Presenter
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