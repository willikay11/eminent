<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/29/17
 * Time: 9:06 AM
 */

namespace App\Http\Controllers;


use eminent\API\SortFilterPaginate;
use eminent\Models\Sources;
use eminent\Sources\SourcesRepository;
use eminent\Sources\SourcesRules;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    use SourcesRules;

    use SortFilterPaginate;

    protected $sourcesRepository;

    public function __construct(SourcesRepository $sourcesRepository)
    {
        $this->sourcesRepository = $sourcesRepository;
    }

    public function getAllSources()
    {
        $roles = $this->sortFilterPaginate(new Sources(), [], function ($source)
        {
            return[
                'id' => $source->id,
                'name' => $source->name,
                'active' => $source->present()->activeStatus,
            ];
        },null, null);

        return self::toResponse(null, $roles);
    }

    public function index()
    {
        return view('sources.index');
    }

    public function storeSource(Request $request)
    {
        if(is_null($request->get('sourceId')))
        {
            return $this->save($request);
        }

        return $this->edit($request);

    }

    public function save($request)
    {
        $validation = $this->validateSourceCreate($request);

        if($validation)
        {
            $response = [
                'success' => false,
                'message' => 'Validation failed'
            ];

            return $response;
        }

        $designation = $this->sourcesRepository->createSource($request->toArray());

        if($designation)
        {
            $response = [
                'success' => true,
                'message' => 'Source added successfully'
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
        $validation = $this->validateSourceEdit($request);

        if($validation)
        {
            $response = [
                'success' => false,
                'message' => 'Validation failed'
            ];

            return $response;
        }

        $designation = $this->sourcesRepository->updateSource($request->toArray());

        if($designation)
        {
            $response = [
                'success' => true,
                'message' => 'Source edited successfully'
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