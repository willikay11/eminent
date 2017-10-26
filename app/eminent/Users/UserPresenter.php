<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/26/17
 * Time: 10:26 AM
 */

namespace eminent\Users;


use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter
{
    public function fullName()
    {
        return $this->contact->firstname .' '. $this->contact->lastname;
    }

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