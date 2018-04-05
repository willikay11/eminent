@extends('dashboard.default')


@section('main-content')

    <section class="content-header">
        <h1>
            User Roles List
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Roles</li>
        </ol>
    </section>

    <section class="content">
        <user-roles user-id="{!! $userId !!}" inline-template>
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <div class="pull-left">
                                <h3 class="box-title" style="padding-bottom: 25px">@{{ username }}</h3>
                            </div>

                            <div class="pull-right box-tools">
                                <div class="col-lg-6" style="text-align: right">
                                    @if(in_array(1, getPermissions()))
                                        <el-button type="primary" plain icon="el-icon-plus"  v-on:click="addUserRole()">Add Role</el-button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <el-table
                                :data="tableData"
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

                            <el-table-column
                                    label="Actions">
                                <template slot-scope="scope">
                                    <el-button @click="viewRole(scope.row)" size="small">View</el-button>
                                    <el-button @click="revokePermissionFromUser(scope.row)" size="small">Revoke</el-button>
                                </template>
                            </el-table-column>
                        </el-table>

                    </div>
                </div>
            </div>
        </user-roles>
    </section>
@stop