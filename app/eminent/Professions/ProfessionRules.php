<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/26/17
 * Time: 9:24 AM
 */
namespace eminent\Professions;

use eminent\Rules\Rules;

trait ProfessionRules
{

    use Rules;

    public function validateProfessionCreate($request)
    {
        $rules = [
            'name' => 'required | unique:professions',
            'active' => 'required'
        ];

        return $this->verdict($request, $rules);
    }

    public function validateProfessionEdit($request)
    {
        $rules = [
            'name' => 'required | unique:professions,name,' . $request->get('professionId'),
            'active' => 'required'
        ];

        return $this->verdict($request, $rules);
    }
}