@extends('layouts.default')

@section('content')

    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <p><b>Eminent Business Group</b> ltd.</p>
            </div>
            <div class="login-box-body">
                <p class="login-box-msg">Sign in to start your session</p>

                {!! Form::open(['route' => 'login.auth']) !!}
                <div class="form-group has-feedback">
                    {!! Form::text('email', null, ['class' => 'form-control ', 'placeholder' => 'email']) !!}
                </div>
                <div class="form-group has-feedback">
                    {!! Form::password('password', ['class' => 'form-control ebg-input', 'placeholder' => 'password']) !!}
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox"> Remember Me
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        {!! Form::submit('Continue', ['class' => 'btn btn-primary btn-block btn-flat']) !!}
                    </div>
                </div>
                {!! Form::close() !!}

                <a href="/password/remind">I forgot my password</a><br>
            </div>
        </div>
    </body>

@stop