<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/2/17
 * Time: 7:12 PM
 */

namespace eminent\Services;


use eminent\Rules\Rules;

trait ServicesRules
{
    use Rules;

    public function validateServiceCreate($request)
    {
        $rules = [
            'name' => 'required | unique:services',
            'abbrev' => 'required | unique:services',
            'active' => 'required'
        ];

        return $this->verdict($request, $rules);
    }

    public function validateServiceEdit($request)
    {
        $rules = [
            'name' => 'required | unique:services,name,' . $request->get('serviceId'),
            'abbrev' => 'required | unique:services,abbrev,' . $request->get('serviceId'),
            'active' => 'required'
        ];

        return $this->verdict($request, $rules);
    }
}