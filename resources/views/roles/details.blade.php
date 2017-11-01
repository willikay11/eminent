@extends('dashboard.default')


@section('dashboard-content')

    <div class="row">
        <div class="col-lg-12">
            <roles-details id="{!! $role->id !!}" name="{!! $role->name !!}" description="{!! $role->description !!}"></roles-details>
        </div>
    </div>
@stop