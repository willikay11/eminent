@extends('dashboard.default')


@section('dashboard-content')

    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <dashboard-contacts user-id="{!! $userId !!}"></dashboard-contacts>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12">
            <dashboard-interactions user-id="{!! $userId !!}"></dashboard-interactions>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12">
            <calendar user-id="{!! $userId !!}"></calendar>
        </div>
    </div>

@stop