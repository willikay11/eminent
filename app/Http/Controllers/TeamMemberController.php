<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/28/17
 * Time: 1:11 PM
 */

namespace App\Http\Controllers;


use eminent\API\SortFilterPaginate;
use eminent\Authorization\Authorizer;
use eminent\Models\TeamMember;
use eminent\team\TeamRepository;
use eminent\TeamMembers\TeamMemberRepository;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    use Authorizer;

    use SortFilterPaginate;
    /**
     * @var TeamRepository
     */
    private $teamRepository;
    /**
     * @var TeamMemberRepository
     */
    private $teamMemberRepository;

    public function __construct(TeamRepository $teamRepository,
                                TeamMemberRepository $teamMemberRepository)
    {

        $this->teamRepository = $teamRepository;
        $this->teamMemberRepository = $teamMemberRepository;
    }

    public function index($id)
    {
        $this->hasPermission('manageTeam');

        $team = $this->teamRepository->getTeamById($id);

        return view('team.member', [
            'team' => $team
        ]);
    }

    public function store(Request $request)
    {
        $response = $this->hasPermission('manageTeam', true);

        if (is_array($response))
        {
            return self::toResponse(null, $response);
        }

        $teamId = $request->get('teamId');

        $users = $request->get('users');

        foreach ($users as $user)
        {
            $this->teamMemberRepository->createTeamMember($user['value'], $teamId);
        }

        return $this->toResponse(null, [
            'success' => true,
            'message' => 'Users added to team successfully'
        ]);
    }

    public function getTeamMembers($teamId)
    {
        $filter = [
            'column' => 'team_id',
            'sign' => '=',
            'value' => $teamId
        ];

        $teamMembers = $this->sortFilterPaginate(new TeamMember(), [$filter], function ($teamMember)
        {
            return[
                'id' => $teamMember->id,
                'user_id' => $teamMember->user_id,
                'email' => $teamMember->user->email,
                'name' => $teamMember->user->contact->present()->fullName,
            ];
        },null, null);

        return self::toResponse(null, $teamMembers);
    }

    public function remove($teamId, $userId)
    {
        $response = $this->hasPermission('manageTeam', true);

        if (is_array($response))
        {
            return self::toResponse(null, $response);
        }

        $teamMember = $this->teamMemberRepository->removeTeamMember($userId, $teamId);

        if($teamMember)
        {
            return $this->toResponse(null, [
                'success' => true,
                'message' => 'User successfully removed from team'
            ]);
        }

        return $this->toResponse(null, [
            'success' => false,
            'message' => 'User not removed from team'
        ]);

    }
    public function toResponse($request = null, $data)
    {
        return response($data);
    }
}