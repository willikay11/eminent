<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/28/17
 * Time: 12:10 PM
 */

namespace eminent\team;


use eminent\Rules\Rules;

trait TeamRules
{

    use Rules;

    public function validateTeamCreate($request)
    {
        $rules = [
            'name' => 'required | unique:teams',
            'user_id' => 'required',
            'active' => 'required'
        ];

        return $this->verdict($request, $rules);
    }

    public function validateTeamEdit($request)
    {
        $rules = [
            'name' => 'required | unique:teams,name,' . $request->get('teamId'),
            'user_id' => 'required',
            'active' => 'required'
        ];

        return $this->verdict($request, $rules);
    }
}