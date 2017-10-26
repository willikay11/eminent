<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/26/17
 * Time: 9:27 AM
 */

namespace eminent\Professions;


use Laracasts\Presenter\Presenter;

class ProfessionPresenter extends Presenter
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