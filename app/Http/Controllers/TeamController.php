<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/28/17
 * Time: 11:22 AM
 */

namespace App\Http\Controllers;


use eminent\API\SortFilterPaginate;
use eminent\Models\Team;
use eminent\Models\User;
use eminent\team\TeamRepository;
use eminent\team\TeamRules;
use Illuminate\Http\Request;

class TeamController extends Controller
{

    use SortFilterPaginate;

    use TeamRules;
    /**
     * @var TeamRepository
     */
    private $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function getTeams()
    {
        $teams = $this->sortFilterPaginate(new Team(), [], function ($team)
        {
            return[
                'id' => $team->id,
                'name' => $team->name,
                'head' => $team->teamHead->contact->present()->fullName,
                'user_id' => $team->user_id,
                'active' => $team->present()->activeStatus,
            ];
        },null, null);

        return self::toResponse(null, $teams);
    }

    public function getInfo()
    {
        $users = User::all();

        $users = $users->map(function ($user)
        {
            return [
                'value' => $user->id,
                'label' => $user->contact->present()->fullName
            ];
        });

        $data = [
            'users' => $users
        ];

        return self::toResponse(null, $data);
    }

    public function index()
    {
        return view('team.index');
    }

    public function store(Request $request)
    {
        if(is_null($request->get('teamId')))
        {
            return $this->save($request);
        }

        return $this->edit($request);

    }

    public function save($request)
    {
        $validation = $this->validateTeamCreate($request);

        if($validation)
        {
            $response = [
                'success' => false,
                'message' => 'Validation failed'
            ];

            return $response;
        }

        $designation = $this->teamRepository->createTeam($request->toArray());

        if($designation)
        {
            $response = [
                'success' => true,
                'message' => 'Team added successfully'
            ];

            return $response;
        }

        $response = [
            'success' => false,
            'message' => 'Oops! An error occurred'
        ];

        return $response;
    }

    public function edit($request)
    {
        $validation = $this->validateTeamEdit($request);

        if($validation)
        {
            $response = [
                'success' => false,
                'message' => 'Validation failed'
            ];

            return $response;
        }

        $designation = $this->teamRepository->updateTeam($request->toArray());

        if($designation)
        {
            $response = [
                'success' => true,
                'message' => 'Team edited successfully'
            ];

            return $response;
        }

        $response = [
            'success' => false,
            'message' => 'Oops! An error occurred'
        ];

        return $response;
    }

    public function toResponse($request = null, $data)
    {
        return response($data);
    }
}