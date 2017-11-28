<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/28/17
 * Time: 11:47 AM
 */

namespace eminent\team;


use eminent\Models\Team;

class TeamRepository
{

    public function createTeam(array $input)
    {
        return Team::create($input);
    }

    public function getTeamById($id)
    {
        return Team::find($id);
    }

    public function updateTeam(array $input)
    {
        $team = $this->getTeamById($input['teamId']);

        return $team->update($input);
    }
}