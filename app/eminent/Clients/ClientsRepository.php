<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/29/17
 * Time: 3:28 PM
 */

namespace eminent\Clients;


use eminent\Models\Client;

class ClientsRepository
{
    public function save($contact, $source, $id = null)
    {
        if(is_null($id))
        {
            $input = [
                'contact_id' => $contact->id,
                'source_id' => $source,
                'status_id' => 2
            ];

            return Client::create($input);
        }
        else
        {
            $input = [
                'contact_id' => $contact->id,
                'source_id' => $source,
            ];

            $client = $contact->clients;

            $client->update($input);

            return $client;
        }
    }

    public function getClientById($id)
    {
        return Client::find($id);
    }

    public function updateClient($clientId, $input)
    {
        $client = $this->getClientById($clientId);

        return $client->update($input);
    }
}