<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/29/17
 * Time: 10:01 AM
 */

namespace eminent\Contacts;


use eminent\Rules\Rules;

trait ContactRules
{

    use Rules;

    public function contactsCreate($request)
    {
        $messages = [
            'email.required_if' => 'Either the phone number or the email address should be provided',
            'phone.required_if' => 'Either the phone number or the email address should be provided',
            'phone.numeric' => 'The phone must contain only numbers i.e. from 0 to 9',
            'product_interests.required' => 'Please provide atleast one product that the contact is interested in',
            'lead_email.unique' => 'The email has already been taken',
            'lead_phone.unique' => 'The phone number has already been taken'
        ];

        $rules = [
            'title_id' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required_if:phone,""| unique:contacts| email',
            'phone' => 'required_if:email,""| unique:contacts| numeric',
            'country_id' => 'required',
            'profession_id' => 'required',
            'gender_id' => 'required',
            'source_id' => 'required',
        ];

        return $this->verdict($request, $rules, $messages);
    }


    public function contactsEdit($request)
    {
        $messages = [
            'email.required_if' => 'Either the phone number or the email address should be provided',
            'phone.required_if' => 'Either the phone number or the email address should be provided',
            'phone.numeric' => 'The phone must contain only numbers i.e. from 0 to 9',
            'product_interests.required' => 'Please provide atleast one product that the contact is interested in',
            'lead_email.unique' => 'The email has already been taken',
            'lead_phone.unique' => 'The phone number has already been taken'
        ];

        $rules = [
            'title_id' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required_if:phone,""| unique:contacts,email,' . $request->get('contactId').'| email',
            'phone' => 'required_if:email,""| unique:contacts,phone,' . $request->get('contactId').'| numeric',
            'country_id' => 'required',
            'profession_id' => 'required',
            'gender_id' => 'required',
            'source_id' => 'required',
        ];

        return $this->verdict($request, $rules, $messages);
    }

    public function clientReassign($request)
    {
        $rules = [
            'user_id' => 'required',
            'assigned' => 'required',
            'contacts' => 'required',
        ];

        return $this->verdict($request, $rules);
    }

}