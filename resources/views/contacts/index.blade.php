@extends('dashboard.default')


@section('dashboard-content')

    <div class="row">
        <div class="col-lg-12">
            <contacts-table user-id="{!! $userId !!}"></contacts-table>
        </div>
    </div>
@stop