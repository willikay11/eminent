<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/29/17
 * Time: 3:31 PM
 */
namespace eminent\UserClients;

use Carbon\Carbon;
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

    /*
     * Get a user client via their id
     */
    public function getUserClientById($id)
    {
        return UserClient::findOrFail($id);
    }

    public function saveScheduledInteraction(array $input)
    {
        $userClient = $this->getUserClientById($input['userClientId']);

        $userClient->next_interaction_date = Carbon::parse($input['next_interaction_date'])->format('Y-m-d:H:m');

        $userClient->save();

        return $userClient;
    }
}