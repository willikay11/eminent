<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/26/17
 * Time: 5:29 PM
 */
namespace eminent\Contacts;

use eminent\Models\Contact;

class ContactsRepository
{

    public function getContactByEmail($email)
    {
        return Contact::where('email', $email)->first();
    }

    public function getContactById($id)
    {
        return Contact::find($id);
    }

    public function save(array $input)
    {
        return Contact::create($input);
    }

    public function updateContact($contact, array $input)
    {
        return $contact->update($input);
    }
}