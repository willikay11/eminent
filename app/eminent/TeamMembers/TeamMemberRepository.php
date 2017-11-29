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

    public function createTeamMember(array $input)
    {
        return TeamMember::create($input);
    }
}