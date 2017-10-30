@extends('layouts.default')

@section('content')

    <div class="login-background">
        <div class="row">
            <div class="login-container">
                <div class="login-overlay"></div>
                <div class="col-lg-6 inner-left">
                    <div class="inner-left-overlay"></div>
                    <div style="z-index: 1">
                        <img class="login-image" src="/img/EBG-logo.png">
                    </div>

                </div>
                <div class="col-lg-6 inner-right">

                    <div class="ebg-input-container">
                        @include('layouts.partials.errors')

                        @include('layouts.partials.flash')
                    </div>

                    <div class="col-lg-12 login-header">
                        <h3>Login</h3>
                        <p>Enter your login details </p>
                    </div>

                    {!! Form::open(['route' => 'login.auth']) !!}
                    <div class="row">
                        <div class="col-lg-12 form-group ebg-input-container">
                            {!! Form::text('email', null, ['class' => 'form-control ebg-input', 'placeholder' => 'example@eminent.co.ke']) !!}
                        </div>

                        <div class="col-lg-12 form-group ebg-input-container">
                            {!! Form::password('password', ['class' => 'form-control ebg-input', 'placeholder' => 'password']) !!}
                        </div>

                        <div class="col-lg-12 ebg-input-container">
                            <div class="col-lg-6">
                                {!! Form::submit('Continue', ['class' => 'btn ebg-button']) !!}
                            </div>

                            <div class="col-lg-6">
                                <a href="/password/remind">Forgot Password</a>
                            </div>
                        </div>
                    </div>

                    {!! Form::close() !!}

                    <div class="login-header ebg-input-container">
                        <p>To use this system you must be an employee of EGB</p>
                        <p>If you do not have an account, kindly request one from the administrator </p>
                    </div>
                </div>
            </div>
        </div>


    </div>



@stop