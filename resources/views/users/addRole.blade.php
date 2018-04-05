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

                    <div style="margin: 10px">
                        {!! Form::open(['route' => ['user.roles', $user->id]]) !!}

                        @foreach($roles as $role)
                            <div class="">
                                {!! Form::checkbox($role->id, true, in_array($role->id, $userRoles->toArray())) !!}&nbsp;&nbsp;{!! $role->description !!}
                                <br/><br/>
                            </div>
                        @endforeach

                        {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop