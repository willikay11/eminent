<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/23/17
 * Time: 9:18 AM
 */

namespace eminent\Rules;

use Validator;

trait Rules
{

    /*
     * Overall validation checker depending on the passed request and rules
     */
    public function verdict($request, $rules, $messages = []){
        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails())
        {
            return $validator;
        }
    }
}