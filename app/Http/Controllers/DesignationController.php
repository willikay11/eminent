<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/24/17
 * Time: 4:34 PM
 */

namespace App\Http\Controllers;


use eminent\API\SortFilterPaginate;
use eminent\Authorization\Authorizer;
use eminent\Designations\DesignationsRepository;
use eminent\Models\Designation;
use Illuminate\Http\Request;
use eminent\Designations\DesignationRules;

class DesignationController extends Controller
{
    use Authorizer;
    use SortFilterPaginate;
    use DesignationRules;

    protected $designationsRepository;

    public function __construct(DesignationsRepository $designationsRepository)
    {
        $this->designationsRepository = $designationsRepository;
    }

    public function getDesignations()
    {
        $designations = $this->sortFilterPaginate(new Designation(), [], function ($designation)
        {
            return[
                'id' => $designation->id,
                'name' => $designation->name,
                'active' => $designation->present()->activeStatus
            ];
        },null, null);

        return self::toResponse(null, $designations);
    }

    public function index()
    {
        $this->hasPermission('manageDesignation');

        return view('designation.index');
    }

    public function storeDesignation(Request $request)
    {
        $this->hasPermission('manageDesignation', true);

        if (is_array($response))
        {
            return self::toResponse(null, $response);
        }

        if(is_null($request->get('designationId')))
        {
            return $this->save($request);
        }

        return $this->edit($request);

    }

    public function save($request)
    {
        $validation = $this->validateDesignationCreate($request);

        if($validation)
        {
            $response = [
                'success' => false,
                'message' => 'Validation failed'
            ];

            return $response;
        }

        $designation = $this->designationsRepository->createDesignation($request->toArray());

        if($designation)
        {
            $response = [
                'success' => true,
                'message' => 'Designation added successfully'
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
        $validation = $this->validateDesignationEdit($request);

        if($validation)
        {
            $response = [
                'success' => false,
                'message' => 'Validation failed'
            ];

            return $response;
        }

        $designation = $this->designationsRepository->updateDesignation($request->toArray());

        if($designation)
        {
            $response = [
                'success' => true,
                'message' => 'Designation edited successfully'
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