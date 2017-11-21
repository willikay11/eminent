@extends('dashboard.default')


@section('dashboard-content')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="col-lg-12 panel-header">
                    <div class="col-lg-6">
                        <h4>Edit User Roles</h4>
                    </div>
                    <div class="col-lg-6" style="text-align: right">
                    </div>
                </div>
                <div class="panel-body">
                    {!! Form::open(['route' => ['user.roles', $user->id]]) !!}

                    @foreach($roles as $role)
                        <div class="">
                            {!! Form::checkbox($role->id, true, in_array($role->id, $userRoles->toArray())) !!}&nbsp;&nbsp;{!! $role->description !!}<br/><br/>
                        </div>
                    @endforeach

                    {!! Form::submit('Submit', ['class' => 'success button']) !!}

                    {!! Form::close() !!}
                </div>
                <hr class="panel-hr">
                <div class="panel-footer">
                    <div class="block"></div>
                </div>
            </div>
        </div>
@stop