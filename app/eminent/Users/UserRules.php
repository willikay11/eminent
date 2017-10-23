<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/23/17
 * Time: 9:18 AM
 */

namespace eminent\Users;


use eminent\Rules\Rules;

trait UserRules
{
    /*
     * Get the overall rules trait
     */
    use Rules;

    /*
    * USERS
    */
    /*
     * Validate users creation
     */
    public function usersCreate($request)
    {
        $messages = [
            'employment_date.required_if' => 'An employment date should be provided for a distribution department member',
            'start_date.required_unless' => 'The job position start date is required'
        ];

        $rules = [
            'email' => 'required | unique:users| exists:contacts,email',
            'designation' => 'required',
            'role_id' => 'required',
            'department_id' => 'required',
            'employment_date' => 'required_if:department_id,1',
            'start_date' => 'required_unless:position_id,""',
            'can_be_assigned_lead' => 'required'
        ];

        return $this->verdict($request, $rules, $messages);
    }

    /*
     * Validate users update
     */
    public function usersUpdate($request, $id, $contactId)
    {
        $messages = [
            'employment_date.required_if' => 'An employment date should be provided for a distribution department member',
        ];

        $rules = [
            'firstname' => 'required',
            'lastname' => 'required',
            'title_id' => 'required',
            'gender_id' => 'required',
            'email' => 'required | unique:users,email,'.$id .' | unique:contacts,email,'.$contactId,
            'phone' => 'unique:contacts,phone,' . $contactId,
            'designation' => 'required',
            'role_id' => 'required',
            'department_id' => 'required',
            'employment_date' => 'required_if:department_id,1',
            'can_be_assigned_lead' => 'required'
        ];

        return $this->verdict($request, $rules, $messages);
    }

    /*
     * Get the rules applicable for a new contact user
     */
    public function userNewCreate($request)
    {
        $messages = [
            'employment_date.required_if' => 'An employment date should be provided for a distribution department member',
            'start_date.required_unless' => 'The job position start date is required'
        ];

        $rules = [
            'email' => 'required | email | unique:contacts| unique:users',
            'firstname' => 'required',
            'lastname' => 'required',
            'title_id' => 'required',
            'gender_id' => 'required',
            'phone' => 'unique:contacts',
            'department_id' => 'required',
            'role_id' => 'required',
            'employment_date' => 'required_if:department_id,1',
            'designation' => 'required',
            'user_type_id' => 'required',
            'start_date' => 'required_unless:position_id,""',
            'can_be_assigned_lead' => 'required'
        ];

        return $this->verdict($request, $rules, $messages);
    }

    /*
    * Get the rules applicable for a existing contact user
    */
    public function userExistingCreate($request)
    {
        $messages = [
            'employment_date.required_if' => 'An employment date should be provided for a distribution department member',
            'start_date.required_unless' => 'The job position start date is required'
        ];

        $rules = [
            'email' => 'required | unique:users| exists:contacts,email',
            'department_id' => 'required',
            'role_id' => 'required',
            'employment_date' => 'required_if:department_id,1',
            'designation' => 'required',
            'start_date' => 'required_unless:position_id,""',
            'can_be_assigned_lead' => 'required'
        ];

        return $this->verdict($request, $rules, $messages);
    }

    /*
     * Validate users password creation
     */
    public function usersPassword($request)
    {
        $rules = [
            'password'=>'required|min:8|confirmed|alpha_num'
        ];

        return $this->verdict($request, $rules);
    }

    /*
     * ROLES
     */
    /*
     * Validate roles creation
     */
    public function rolesCreate($request)
    {
        $rules = [
            'name' => 'required | unique:roles',
            'description' => 'required'
        ];

        return $this->verdict($request, $rules);
    }

    /*
     * Validate roles update
     */
    public function rolesUpdate($request, $id)
    {
        $rules = [
            'name' => 'required | unique:roles,name,' . $id,
            'description' => 'required'
        ];

        return $this->verdict($request, $rules);
    }

    /*
     * AUTH
     */
    /*
     * Validate the login form
     */
    public function login($request)
    {
        $rules = [
            'email' => 'required',
            'password' => 'required'
        ];
        return $this->verdict($request, $rules);
    }

    /*
     * Validate the one time access pin
     */
    public function confirm($request)
    {
        $rules = [
            'one_time_key'=>'required | digits:6'
        ];

        return $this->verdict($request, $rules);
    }

    /*
     * Validate Password Reminder Email Form
     */
    public function passwordReminder($request)
    {
        $rules = [
            'email'=>'required'
        ];

        return $this->verdict($request, $rules);
    }
}