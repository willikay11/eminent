@extends('dashboard.default')


@section('main-content')

    <section class="content-header">
        <h1>
            Roles Details
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/roles"><i class="fa fa-dashboard"></i> Roles</a></li>
            <li class="active">Role Details</li>
        </ol>
    </section>

    <section class="content">
        <roles-details id="{!! $role->id !!}" name="{!! $role->name !!}" description="{!! $role->description !!}"
                       inline-template>
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <div class="pull-left">
                                <h3 class="box-title" style="padding-bottom: 25px">Role Details</h3>
                            </div>
                        </div>

                        <div class="row" style="padding-left: 20px">
                            <h5>@{{ name }}</h5>
                            <h6>@{{ description }}</h6>
                        </div>

                        <hr>

                        <h4>Members</h4>

                        <el-table
                                :data="memberTableData"
                                stripe
                                style="width: 100%">
                            <el-table-column
                                    prop="name"
                                    label="Name">
                            </el-table-column>
                            <el-table-column
                                    prop="email"
                                    label="Email">
                            </el-table-column>
                            @if(in_array(15, getPermissions()))
                                <el-table-column
                                        label="Actions"
                                        width="120">
                                    <template slot-scope="scope">
                                        <el-button @click="revokeUser(scope.row)" size="small">Revoke</el-button>
                                    </template>
                                </el-table-column>
                            @endif
                        </el-table>

                        <div class="panel-footer">
                            <div class="block">
                                <el-pagination
                                        layout="prev, pager, next"
                                        :total="total">
                                </el-pagination>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <div class="pull-left">
                                <h3 class="box-title" style="padding-bottom: 25px">Role Permissions</h3>
                            </div>

                            <div class="pull-right box-tools">
                                <div class="col-lg-6" style="text-align: right">
                                    @if(in_array(15, getPermissions()))
                                        <el-button type="primary" plain icon="el-icon-plus"
                                                   v-on:click="showAddRolePermission()">Add Role Permission
                                        </el-button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <el-table
                                :data="permissionsTableData"
                                stripe
                                style="width: 100%">
                            <el-table-column
                                    prop="name"
                                    label="Name">
                            </el-table-column>
                            <el-table-column
                                    prop="description"
                                    label="Description">
                            </el-table-column>
                            @if(in_array(15, getPermissions()))
                                <el-table-column
                                        label="Actions"
                                        width="120">
                                    <template slot-scope="scope">
                                        <el-button @click="revokePermission(scope.row)" size="small">Revoke</el-button>
                                    </template>
                                </el-table-column>
                            @endif
                        </el-table>
                        <div class="panel-footer">
                            <div class="block">
                                <el-pagination
                                        layout="prev, pager, next"
                                        :total="totalPermissions">
                                </el-pagination>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </roles-details>
    </section>
@stop