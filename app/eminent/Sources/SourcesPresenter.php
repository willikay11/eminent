<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/29/17
 * Time: 9:03 AM
 */

namespace eminent\Sources;

use Laracasts\Presenter\Presenter;

class SourcesPresenter extends Presenter
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