<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/26/17
 * Time: 9:27 AM
 */

namespace eminent\Professions;


use eminent\Models\Profession;

class ProfessionRepository
{

    public function getProfessionById($id)
    {
        return Profession::find($id);
    }

    public function createProfession(array $input)
    {
        return Profession::create($input);
    }

    public function updateProfession(array $input)
    {
        $designation = $this->getProfessionById($input['professionId']);

        return $designation->update($input);
    }
}