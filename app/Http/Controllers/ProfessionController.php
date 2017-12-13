<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/26/17
 * Time: 9:10 AM
 */

namespace App\Http\Controllers;


use eminent\API\SortFilterPaginate;
use eminent\Authorization\Authorizer;
use eminent\Models\Profession;
use eminent\Professions\ProfessionRepository;
use eminent\Professions\ProfessionRules;
use Illuminate\Http\Request;

class ProfessionController extends Controller
{
    use Authorizer;
    use SortFilterPaginate;
    use ProfessionRules;

    protected $professionRepository;

    public function __construct(ProfessionRepository $professionRepository)
    {
        $this->professionRepository = $professionRepository;
    }

    public function getProfessions()
    {
        $professions = $this->sortFilterPaginate(new Profession(), [], function ($profession)
        {
            return[
                'id' => $profession->id,
                'name' => $profession->name,
                'active' => $profession->present()->activeStatus
            ];
        },null, null);

        return self::toResponse(null, $professions);
    }

    public function index()
    {
        $this->hasPermission('manageProfessions');

        return view('professions.index');
    }

    public function storeProfession(Request $request)
    {
        $response = $this->hasPermission('manageProfessions', true);

        if (is_array($response))
        {
            return self::toResponse(null, $response);
        }

        if(is_null($request->get('professionId')))
        {
            return $this->save($request);
        }

        return $this->edit($request);

    }

    public function save($request)
    {
        $validation = $this->validateProfessionCreate($request);

        if($validation)
        {
            $response = [
                'success' => false,
                'message' => 'Validation failed'
            ];

            return $response;
        }

        $designation = $this->professionRepository->createProfession($request->toArray());

        if($designation)
        {
            $response = [
                'success' => true,
                'message' => 'Profession added successfully'
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
        $validation = $this->validateProfessionEdit($request);

        if($validation)
        {
            $response = [
                'success' => false,
                'message' => 'Validation failed'
            ];

            return $response;
        }

        $designation = $this->professionRepository->updateProfession($request->toArray());

        if($designation)
        {
            $response = [
                'success' => true,
                'message' => 'Profession edited successfully'
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