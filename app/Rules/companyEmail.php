<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class companyEmail implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        list($user, $domain) = explode('@', $value);

//        if (strtolower($domain) != 'eminent.co.ke' || strtolower($domain != 'sterlingq.com'))
//        {
//            return false;
//        }
//
//        return true;

        return strtolower($domain) != 'eminent.co.ke' || strtolower($domain != 'sterlingq.com');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be either eminent.co.ke or sterlingq.com .';
    }
}
