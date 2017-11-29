<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/28/17
 * Time: 1:11 PM
 */

namespace App\Http\Controllers;


use eminent\team\TeamRepository;

class TeamMemberController extends Controller
{

    /**
     * @var TeamRepository
     */
    private $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {

        $this->teamRepository = $teamRepository;
    }

    public function index($id)
    {
        $team = $this->teamRepository->getTeamById($id);

        return view('team.member', [
            'team' => $team
        ]);
    }
}