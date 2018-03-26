<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 3/20/18
 * Time: 6:42 PM
 */

namespace App\Http\Controllers;


use eminent\API\SortFilterPaginate;
use eminent\Models\Activity;
use eminent\Models\Report;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{

    use SortFilterPaginate;

    protected $labels;

    protected $completed;

    protected $todo;

    protected $ongoing;

    protected $review;

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

    public function viewUsers($id)
    {
        return view('reports.users', ['id' => $id]);
    }

    public function viewUserReport($id, $userId)
    {
        return view('reports.report', ['reportId' => $id, 'userId' => $userId]);
    }

    public function getActivityReportData(Request $request)
    {
        $startDate = $request->get('start_date');

        $endDate = $request->get('end_date');

        $userId = $request->get('user_id');

        $activities = Activity::where('updated_at', '>=', Carbon::parse($startDate))
                ->where('updated_at', '<=', Carbon::parse($endDate))
                ->where('user_id', $userId)
                ->get();

        $dates = $activities->pluck('updated_at');

        collect($dates)->map(function($date) use ($activities)
        {
            $this->labels[] = Carbon::parse($date)->format('Y-m-d');
            $this->todo[] = $activities->where('updated_at', '>=',Carbon::parse($date)->startOfDay())->where('updated_at', '<=',Carbon::parse($date)->endOfDay())->where('activity_status_id', 1)->count();
            $this->ongoing[] = $activities->where('updated_at', '>=',Carbon::parse($date)->startOfDay())->where('updated_at', '<=',Carbon::parse($date)->endOfDay())->where('activity_status_id', 2)->count();
            $this->review[] = $activities->where('updated_at', '>=',Carbon::parse($date)->toDateString())->where('updated_at', '<=',Carbon::parse($date)->endOfDay())->where('activity_status_id',3)->count();
            $this->completed[] = $activities->where('updated_at', '>=',Carbon::parse($date)->startOfDay())->where('updated_at', '<=',Carbon::parse($date)->endOfDay())->where('activity_status_id', 4)->count();

        });

        $data = [
            'labels' => $this->labels,
            'todoLabel' => 'Todo',
            'todo' => $this->todo,
            'ongoingLabel' => 'Ongoing',
            'ongoing' => $this->ongoing,
            'reviewLabel' => 'Review',
            'review' => $this->review,
            'completedLabel' => 'Completed',
            'completed' => $this->completed,
        ];

        return $this->toResponse(null, [
            'success' => true,
            'activities' => $data,
            'message' => 'Search Completed'
        ]);
    }

    public function toResponse($request = null, $data)
    {
        return response($data);
    }
}