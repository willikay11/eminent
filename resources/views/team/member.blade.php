@extends('dashboard.default')


@section('dashboard-content')

    <div class="row">
        <div class="col-lg-12">
            <team-member-table team-id="{!! $team->id !!}" team-name="{!! $team->name !!}"></team-member-table>
        </div>
    </div>
@stop