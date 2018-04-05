@extends('layouts.default')

@section('content')

    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <p><b>Eminent Business Group</b> ltd.</p>
            </div>
            <div class="login-box-body">
                <p class="login-box-msg">Submit the token to start the session</p>

                {!! Form::open(['route' => ['login.confirm', $email]]) !!}
                <div class="form-group has-feedback">
                        {!! Form::text('one_time_key', null, ['class' => 'form-control']) !!}
                </div>

                <div class="row">
                    <div class="col-xs-4">
                        {!! Form::submit('Continue', ['class' => 'btn btn-primary btn-block btn-flat']) !!}
                    </div>
                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </body>
@stop