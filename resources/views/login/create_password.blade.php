@extends('layouts.default')

@section('content')

    <div class="login-background">
        <div class="row">
            <div class="login-container">
                <div class="login-overlay"></div>
                <div class="col-lg-6 inner-left">
                    <div class="inner-left-overlay"></div>
                    <div class="vertical-center">
                        <img class="login-image" src="/img/EBG-logo.png">
                        <div class="login-text">
                            <p class="login-welcome-text">Welcome</p>
                            <p class="login-banner">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                ut labore et dolore magna aliqua.</p>
                        </div>
                    </div>

                </div>
                <div class="col-lg-6 inner-right">

                    <div class="vertical-center">
                        <div class="ebg-input-container">
                            @include('layouts.partials.errors')

                            @include('layouts.partials.flash')
                        </div>

                        <div class="col-lg-12 login-header">
                            <h3>Token</h3>
                            <p>Create a new password for your account.</p>
                        </div>

                        {!! Form::open(['route' => ['users.create_password', $id]]) !!}
                        <div class="row">
                            <div class="col-lg-12 form-group ebg-input-container">
                                {!! Form::password('password', ['class' => 'form-control ebg-input', 'placeholder' => 'Password'] )!!}
                            </div>

                            <div class="col-lg-12 form-group ebg-input-container">
                                {!! Form::password('password_confirmation', ['class' => 'form-control ebg-input', 'placeholder' => 'Confirm password'] )!!}
                            </div>

                            <div class="col-lg-12 ebg-input-container">
                                <div class="col-lg-6">
                                    {!! Form::submit('Continue', ['class' => 'btn ebg-button']) !!}
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


    </div>

@stop