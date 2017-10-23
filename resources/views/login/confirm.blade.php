@extends('layouts.default')

@section('content')

    <div class="col-lg-offset-1 col-lg-6">
        {!! Form::open(['route' => ['login.confirm', $email]]) !!}

        {!! Form::text('one_time_key', null) !!}

        {!! Form::submit('Login') !!}

        {!! Form::close() !!}
    </div>


@stop