<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/2/17
 * Time: 7:10 PM
 */
namespace eminent\Services;

use Laracasts\Presenter\Presenter;

class ServicesPresenter extends Presenter
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