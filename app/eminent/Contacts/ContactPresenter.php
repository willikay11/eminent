<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/26/17
 * Time: 5:30 PM
 */
namespace eminent\Contacts;

use Carbon\Carbon;
use eminent\Models\Contact;
use eminent\Models\UserClient;
use Laracasts\Presenter\Presenter;

class ContactPresenter extends Presenter
{

    /*
     * Setup the fullname
     */
    public function fullName()
    {
        if($this->type == 1)
        {
            return $this->firstname . ' ' . $this->lastname;
        }
        else
        {
            return $this->organization;
        }
    }

    /*
     * Setup a complete name with title
     */
    public function completeName()
    {
        if($this->type == 1)
        {
            return $this->titleName->name . ' '. $this->firstname . ' ' . $this->lastname;
        }
        else
        {
            return $this->organization;
        }
    }

    /*
     * Display the status for a contact ie Assigned or Unassigned
     */
    public function status()
    {
        if($this->clients)
        {
            return "Assigned";
        }
        else
        {
            return "Unassigned";
        }
    }

    /*
     * Check if a client Exists for the contact
     */
    public function clientExists()
    {
        $client = $this->clients;

        if($client)
        {
            $userClient = $client->userClient;

            if(count($userClient) > 0)
            {
                return 1;
            }
        }

        return 0;
    }

    /*
     * Check if the contact is assiged a religion
     */
    public function religion()
    {
        if($this->religionName)
        {
            return $this->religionName->name;
        }
        else
        {
            return "Religion Unspecified";
        }
    }

    /*
     * Check if the contact is assiged a country
     */
    public function country()
    {
        if($this->countryName)
        {
            return $this->countryName->name;
        }
        else
        {
            return "Country Unspecified";
        }
    }

    /*
     * Get the next client from the current userclient
     */
    public function nextContact()
    {
        $nextQuery = Contact::where('id', '<', $this->id)->orderBy('id', 'DESC')->first();

        if($nextQuery)
        {
            return $nextQuery->id;
        }
        else
        {
            return null;
        }
    }

    /*
     * Get the next previous for the user
     */
    public function previousContact()
    {
        $previousQuery = Contact::where('id', '>', $this->id)->orderBy('id', 'ASC')->first();

        if($previousQuery)
        {
            return $previousQuery->id;
        }
        else
        {
            return null;
        }
    }

    /*
     * Get the status of the client
     */
    public function clientStatus()
    {
        if($this->clients)
        {
            return $this->clients->status->name;
        }
        else
        {
            return "New Contact";
        }
    }

    /*
     * Get the status of the client
     */
    public function clientStatusId()
    {
        if($this->clients)
        {
            return $this->clients->status_id;
        }
        else
        {
            return 0;
        }
    }

    /*
     * Get the source for a contact
     */
    public function contactSource()
    {
        if($this->clients)
        {
            return $this->clients->source->name;
        }
        else
        {
            return "Unspecified";
        }
    }

    /*
     * Indicate the type of contact
     */
    public function typeName()
    {
        if($this->type == 1)
        {
            return "Individual";
        }
        else
        {
            return "Corporate";
        }
    }

    /*
     * Get the email for the contact if any
     */
    public function contactEmail()
    {
        if($this->email)
        {
            return $this->email;
        }
        else
        {
            return null;
        }
    }

    /*
     * Get the phone number for the contact if any
     */
    public function contactPhone()
    {
        if($this->phone)
        {
            return $this->phone;
        }
        else
        {
            return null;
        }
    }

    /*
     * Indicate whether the contact has a phone or not
     */
    public function hasPhone()
    {
        if($this->phone == '')
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    /*
     * Indicate whether the contact has an email or not
     */
    public function hasEmail()
    {
        if($this->email == '')
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    /*
    * Get the userClient profile for the contact if any
    */
    public function userClient()
    {
        $client = $this->clients;

        if ($client) {
            $userClients = $client->userClient;

            $userClientsCount = count($userClients);

            if ($userClientsCount > 0) {
                $index = 0;

                $user = '';

                foreach ($userClients as $userClient) {
                    if ($index == $userClientsCount - 1 && $userClientsCount != 1) {
                        $user .= ' & ' . $userClient->user->contact->present()->fullName;
                    } elseif ($index != 0) {
                        $user .= ', ' . $userClient->user->contact->present()->fullName;
                    } else {
                        $user .= $userClient->user->contact->present()->fullName;
                    }

                    $index++;
                }

                return $user;
            }
        }
        return null;
    }

    /*
     * Get the userEmail profile for the contact if any
     */
    public function userEmail()
    {
        $client = $this->clients;

        if ($client)
        {
            $userClients = $client->userClient;

            $userClientsCount = count($userClients);

            if ($userClientsCount > 0)
            {
                $index = 0;

                $user = '';

                foreach ($userClients as $userClient)
                {
                    if ($index == $userClientsCount - 1 && $userClientsCount != 1)
                    {
                        $user .= ' & ' . $userClient->user->contact->email;
                    }
                    elseif ($index != 0)
                    {
                        $user .= ', ' . $userClient->user->contact->email;
                    }
                    else
                    {
                        $user .= $userClient->user->contact->email;
                    }

                    $index++;
                }

                return $user;
            }
        }
        return null;
    }

    /*
     * Get the last interaction date for the contact
     */
    public function lastInteractionDate()
    {
        $client = $this->clients;

        if($client)
        {
            $interactions = $client->interactions;

            if(count($interactions) > 0)
            {
                return Carbon::parse($client->interactions->last()->interaction_date)->toDateString();
            }
        }

        return "";
    }

    /*
     * Get the last interaction remark
     */
    public function lastInteractionRemark()
    {
        $client = $this->clients;

        if($client)
        {
            $interactions = $client->interactions;

            if(count($interactions) > 0)
            {
                return $client->interactions->last()->remarks;
            }
        }

        return "";
    }

    /*
     * Get the user client when you are given a user id
     */
    public function getUserClient($userId)
    {
        return UserClient::where('user_id', $userId)->whereHas('client', function ($q)
        {
            $q->where('contact_id', $this->id);
        })->first();
    }

    /*
     * Get the user client id for the contact if any
     */
    public function getUserClientId($userId)
    {
        $userClient = $this->getUserClient($userId);

        if(! is_null($userClient))
        {
            return $userClient->id;
        }
    }

    /*
     * Get the next interaction date for the user
     */
    public function nextInteraction($userId)
    {
        $userClient = $this->getUserClient($userId);

        if(! is_null($userClient))
        {
            return $userClient->present()->nextInteraction;
        }

        return "Not scheduled";
    }
}