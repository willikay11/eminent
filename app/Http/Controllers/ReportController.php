<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 3/20/18
 * Time: 6:42 PM
 */

namespace App\Http\Controllers;


use eminent\API\SortFilterPaginate;
use eminent\Models\Report;

class ReportController extends Controller
{

    use SortFilterPaginate;

    public function __construct()
    {

    }

    public function getReports()
    {

        $reports = $this->sortFilterPaginate(new Report(), [], function ($report)
        {
            return[
                'id' => $report->id,
                'name' => $report->name,
                'description' => $report->description,
            ];
        },null, null);

        return self::toResponse(null, [
            'success' => true,
            'reports' => $reports,
            'message' => 'Reports loaded'
        ]);
    }

    public function index()
    {
        return view('reports.index');
    }

    public function toResponse($request = null, $data)
    {
        return response($data);
    }
}