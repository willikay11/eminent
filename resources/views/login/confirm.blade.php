@extends('layouts.default')

@section('content')

    <div class="login-background">
        <div class="row">
            <div class="login-container">
                <div class="col-lg-6 inner-left">
                    <img class="login-image" src="img/EBG-logo.png">
                </div>
                <div class="col-lg-6 inner-right">

                    <div class="ebg-input-container">
                        @include('layouts.partials.errors')

                        @include('layouts.partials.flash')
                    </div>

                    <div class="col-lg-12 login-header">
                        <h3>Token</h3>
                        <p>Enter the six digit token you have received via your email. </p>
                    </div>

                    {!! Form::open(['route' => ['login.confirm', $email]]) !!}
                    <div class="row">
                        <div class="col-lg-12 form-group ebg-input-container">
                            {!! Form::text('one_time_key', null, ['class' => 'form-control ebg-input']) !!}
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

@stop