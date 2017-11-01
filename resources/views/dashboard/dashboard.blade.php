@extends('dashboard.default')


@section('dashboard-content')

    <div class="row">
        <div class="col-lg-6">
            <dashboard-contacts></dashboard-contacts>
        </div>

        <div class="col-lg-6">
            <dashboard-interactions></dashboard-interactions>
        </div>
    </div>

@stop