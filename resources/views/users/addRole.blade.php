@extends('dashboard.default')


@section('main-content')

    <section class="content-header">
        <h1>
            Add User Role
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">User Role</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="pull-left">
                            <h3 class="box-title" style="padding-bottom: 25px">Edit User Roles</h3>
                        </div>
                    </div>

                    {!! Form::open(['route' => ['user.roles', $user->id]]) !!}

                    @foreach($roles as $role)
                        <div class="">
                            {!! Form::checkbox($role->id, true, in_array($role->id, $userRoles->toArray())) !!}&nbsp;&nbsp;{!! $role->description !!}
                            <br/><br/>
                        </div>
                    @endforeach

                    {!! Form::submit('Submit', ['class' => 'success button']) !!}

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </section>

    {{--<div class="row">--}}
    {{--<div class="col-lg-12">--}}
    {{--<div class="panel panel-default">--}}
    {{--<div class="col-lg-12 panel-header">--}}
    {{--<div class="col-lg-6">--}}
    {{--<h4>Edit User Roles</h4>--}}
    {{--</div>--}}
    {{--<div class="col-lg-6" style="text-align: right">--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="panel-body">--}}
    {{--{!! Form::open(['route' => ['user.roles', $user->id]]) !!}--}}

    {{--@foreach($roles as $role)--}}
    {{--<div class="">--}}
    {{--{!! Form::checkbox($role->id, true, in_array($role->id, $userRoles->toArray())) !!}&nbsp;&nbsp;{!! $role->description !!}<br/><br/>--}}
    {{--</div>--}}
    {{--@endforeach--}}

    {{--{!! Form::submit('Submit', ['class' => 'success button']) !!}--}}

    {{--{!! Form::close() !!}--}}
    {{--</div>--}}
    {{--<hr class="panel-hr">--}}
    {{--<div class="panel-footer">--}}
    {{--<div class="block"></div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
@stop