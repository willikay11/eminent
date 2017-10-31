@extends('dashboard.default')


@section('dashboard-content')

    <div class="row">
        <div class="col-lg-12">
            <contact-details :user-client-id="{!! $id !!}"></contact-details>
        </div>
    </div>

@stop