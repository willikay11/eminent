<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/2/17
 * Time: 6:33 PM
 */

namespace eminent\Notes;


use eminent\Rules\Rules;

trait NotesRules
{
    use Rules;

    public function validateNote($request)
    {
        $rules = [
            'note' => 'required',
        ];

        return $this->verdict($request, $rules);
    }
}