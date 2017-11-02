<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/2/17
 * Time: 6:29 PM
 */

namespace App\Http\Controllers;


use eminent\Notes\NotesRepository;
use eminent\Notes\NotesRules;
use eminent\UserClients\UserClientsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    use NotesRules;

    protected $notesRepository;

    protected $userClientsRepository;

    public function __construct(NotesRepository $notesRepository,
                                UserClientsRepository $userClientsRepository)
    {
        $this->notesRepository = $notesRepository;
        $this->userClientsRepository = $userClientsRepository;
    }

    public function save(Request $request)
    {
        $validation = $this->validateNote($request);

        if($validation)
        {
            $errorArray = $validation->messages()->getMessages();

            return self::toResponse(null, [
                'success' => false,
                'errorMessages' => array_flatten($errorArray),
            ]);
        }

        $userClient = $this->userClientsRepository->getUserClientById($request->get('userClientId'));

        $input = $request->all();

        $input['user_id'] = Auth::id();

        $input['client_id'] = $userClient->client_id;

        $note = $this->notesRepository->save($input);

        if($note)
        {
            return self::toResponse(null, [
                'success' => true,
                'message' => 'Note added successfully'
            ]);
        }

        return self::toResponse(null, [
            'success' => false,
            'message' => 'Note not added'
        ]);
    }

    public function toResponse($request = null, $data)
    {
        return response($data);
    }
}