<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/29/17
 * Time: 9:05 AM
 */

namespace eminent\Sources;


use eminent\Rules\Rules;

trait SourcesRules
{
    use Rules;

    public function validateSourceCreate($request)
    {
        $rules = [
            'name' => 'required | unique:sources',
            'active' => 'required'
        ];

        return $this->verdict($request, $rules);
    }

    public function validateSourceEdit($request)
    {
        $rules = [
            'name' => 'required | unique:sources,name,' . $request->get('sourceId'),
            'active' => 'required'
        ];

        return $this->verdict($request, $rules);
    }
}