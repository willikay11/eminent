@extends('layouts.default')

@section('content')

    <body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <p><b>Eminent Business Group</b> ltd.</p>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Create a new password for your account.</p>

            {!! Form::open(['route' => ['users.create_password', $id]]) !!}
            <div class="form-group has-feedback">
                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password'] )!!}
            </div>

            <div class="form-group has-feedback">
                {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm password'] )!!}
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