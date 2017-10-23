@extends('layouts.default')

@section('content')

    <div class="col-lg-offset-1 col-lg-6">
        {!! Form::open(['route' => 'login.auth']) !!}

        {!! Form::text('email', 'example@gmail.com') !!}

        {!! Form::password('password') !!}

        {!! Form::submit('Login') !!}

        {!! Form::close() !!}
    </div>


@stop