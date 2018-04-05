@extends('dashboard.default')


@section('main-content')

    <section class="content-header">
        <h1>
            Add Role Permissions
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/roles"><i class=""></i> Roles</a></li>
            <li class="active">Role Permissions</li>
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
                            <h3 class="box-title" style="padding-bottom: 25px">Edit Role Roles</h3>
                        </div>
                    </div>

                    <div style="margin: 10px">
                        {!! Form::open(['route' => ['roles.permissions', $role->id]]) !!}

                        @foreach($permissions as $permission)
                            <div class="">
                                {!! Form::checkbox($permission->id, true, in_array($permission->id, $role_permissions->toArray())) !!}&nbsp;&nbsp;{!! $permission->description !!}<br/><br/>
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