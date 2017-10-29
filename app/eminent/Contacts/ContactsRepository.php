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

    public function save(array $input, $id = null)
    {
        if(is_null($id))
        {
            $contact = Contact::create($input);

            return $contact;
        }else
        {
            $contact = Contact::findOrFail($id);

            return $this->updateContact($contact, $input);
        }
    }

    public function updateContact($contact, array $input)
    {
        return $contact->update($input);
    }

    public function getContactByPhone($phone)
    {
        return Contact::where('phone', $phone)->first();
    }
}