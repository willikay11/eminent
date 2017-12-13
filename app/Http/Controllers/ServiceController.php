<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/2/17
 * Time: 7:08 PM
 */

namespace App\Http\Controllers;


use eminent\API\SortFilterPaginate;
use eminent\Authorization\Authorizer;
use eminent\Models\Service;
use eminent\Services\ServicesRepository;
use eminent\Services\ServicesRules;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use Authorizer;

    use SortFilterPaginate;

    use ServicesRules;

    protected $servicesRepository;

    public function __construct(ServicesRepository $servicesRepository)
    {
        $this->servicesRepository = $servicesRepository;
    }

    public function getServices()
    {
        $services = $this->sortFilterPaginate(new Service(), [], function ($service)
        {
            return[
                'id' => $service->id,
                'name' => $service->name,
                'abbrev' => $service->abbrev,
                'active' => $service->present()->activeStatus
            ];
        },null, null);

        return self::toResponse(null, $services);
    }

    public function index()
    {
        $this->hasPermission('manageServices');

        return view('services.index');
    }

    public function store(Request $request)
    {
        $response = $this->hasPermission('manageServices', true);

        if (is_array($response))
        {
            return self::toResponse(null, $response);
        }

        if(is_null($request->get('serviceId')))
        {
            return $this->save($request);
        }

        return $this->edit($request);

    }

    public function save($request)
    {
        $validation = $this->validateServiceCreate($request);

        if($validation)
        {
            $response = [
                'success' => false,
                'message' => 'Validation failed'
            ];

            return $response;
        }

        $department = $this->servicesRepository->createService($request->toArray());

        if($department)
        {
            $response = [
                'success' => true,
                'message' => 'Service added successfully'
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
        $validation = $this->validateServiceEdit($request);

        if($validation)
        {
            $response = [
                'success' => false,
                'message' => 'Validation failed'
            ];

            return $response;
        }

        $department = $this->servicesRepository->updateService($request->toArray());

        if($department)
        {
            $response = [
                'success' => true,
                'message' => 'Service edited successfully'
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