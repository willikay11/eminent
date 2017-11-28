@extends('dashboard.default')


@section('dashboard-content')

    <div class="row">
        <div class="col-lg-12">
            <activities user-id="{!! $user->id !!}"></activities>
        </div>
    </div>
@stop