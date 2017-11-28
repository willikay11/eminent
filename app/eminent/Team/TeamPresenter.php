<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/28/17
 * Time: 12:01 PM
 */

namespace eminent\team;


use Laracasts\Presenter\Presenter;

class TeamPresenter extends Presenter
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