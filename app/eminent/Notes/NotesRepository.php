<?php

/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/2/17
 * Time: 6:29 PM
 */

namespace eminent\Notes;


use eminent\Models\Note;

class NotesRepository
{

    public function getNoteById($id)
    {
        return Note::find($id);
    }

    public function save(array $input)
    {
        return Note::create($input);
    }

    public function getNotesByUserIdAndClientId($userId, $clientId)
    {
        return Note::where('user_id', $userId)->where('client_id', $clientId)->get();

    }
}