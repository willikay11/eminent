<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/31/17
 * Time: 8:49 PM
 */
namespace eminent\Interactions;

use eminent\Models\Interaction;
use Illuminate\Support\Facades\Auth;

class InteractionsRepository
{

    public function save($input, $id)
    {
        $input['user_id'] = Auth::user()->id;

        if(is_null($id))
        {
            $interaction = Interaction::create($input);

            return  $interaction;

        }else{
            $interaction = Interaction::findOrFail($id);

            $interaction->update($input);

            return $interaction;
        }
    }
}