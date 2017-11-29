<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/28/17
 * Time: 1:23 PM
 */

namespace eminent\TeamMembers;


use eminent\Models\TeamMember;

class TeamMemberRepository
{

    public function createTeamMember($userId, $teamId)
    {
        $teamMember = $this->getTeamMemberByUserIdAndTeamId($userId, $teamId);

        if (is_null($teamMember))
        {
            return TeamMember::create([
                'user_id' => $userId,
                'team_id' => $teamId
            ]);
        }
    }

    public function getTeamMemberByUserIdAndTeamId($userId, $teamId)
    {
        return TeamMember::where('user_id', $userId)->where('team_id', $teamId)->first();
    }

    public function removeTeamMember($userId, $teamId)
    {
        $teamMember = $this->getTeamMemberByUserIdAndTeamId($userId, $teamId);

        return $teamMember->delete();
    }
}