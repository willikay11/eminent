@extends('dashboard.default')


@section('dashboard-content')

    <div class="row">
        <div class="col-lg-12">
            <interactions-table user-id="{!! $userId !!}"></interactions-table>
        </div>
    </div>

@stop