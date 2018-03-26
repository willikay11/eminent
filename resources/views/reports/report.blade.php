@extends('dashboard.default')


@section('dashboard-content')

    <div class="row">
        <div class="col-lg-12">
            <activity-report user-id="{!! $userId !!}" report-id="{!! $reportId !!}">
            </activity-report>
        </div>
    </div>

@stop