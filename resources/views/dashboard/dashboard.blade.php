@extends('dashboard.default')


@section('dashboard-content')

    <div class="row">
        <div class="col-lg-6">
            <dashboard-contacts user-id="{!! $userId !!}"></dashboard-contacts>
        </div>

        <div class="col-lg-6">
            <dashboard-interactions user-id="{!! $userId !!}"></dashboard-interactions>
        </div>
    </div>

@stop