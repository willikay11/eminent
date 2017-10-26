<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/26/17
 * Time: 8:44 AM
 */

namespace eminent\Designations;


use Laracasts\Presenter\Presenter;

class DesignationsPresenter extends Presenter
{

    /*
     * Display the end date for a deal
     */
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