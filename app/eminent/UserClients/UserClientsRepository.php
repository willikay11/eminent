<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/29/17
 * Time: 3:31 PM
 */
namespace eminent\UserClients;

use eminent\Models\UserClient;

class UserClientsRepository
{

    public function save($client, $user)
    {
        return UserClient::create([
            'client_id' => $client->id,
            'user_id' => $user,
        ]);
    }
}