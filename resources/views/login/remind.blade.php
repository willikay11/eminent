@extends('layouts.default')

@section('content')

    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <p><b>Eminent Business Group</b> ltd.</p>
            </div>
            <div class="login-box-body">
                <p class="login-box-msg">Reset password - Enter your account email.</p>

                {!! Form::open(['route' => 'login.remind']) !!}
                <div class="form-group has-feedback">
                    {!! Form::text('email', null, ['class' => 'form-control ebg-input']) !!}
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