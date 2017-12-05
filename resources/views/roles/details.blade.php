@extends('dashboard.default')


@section('dashboard-content')

    <div class="row">
        <div class="col-lg-12">
            <roles-details id="{!! $role->id !!}" name="{!! $role->name !!}" description="{!! $role->description !!}" inline-template>
                <div class="panel panel-default">
                    <div class="col-lg-12 panel-header">
                        <div class="col-lg-6">
                            <h4>Role Details</h4>
                        </div>
                        <div class="col-lg-6" style="text-align: right">
                        </div>
                    </div>
                    <div class="panel-body">
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
                    </div>
                    <hr class="panel-hr">
                    <div class="panel-footer">
                        <div class="block">
                            <el-pagination
                                    layout="prev, pager, next"
                                    :total="total">
                            </el-pagination>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="col-lg-12 panel-header">
                            <div class="col-lg-6">
                                <h4>Role Permissions</h4>
                            </div>
                            <div class="col-lg-6" style="text-align: right">
                                @if(in_array(15, getPermissions()))
                                    <button class="btn ebg-button" v-on:click="showAddRolePermission()">Add Role Permission</button>
                                @endif
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
                    </div>
                    <hr class="panel-hr">
                    <div class="panel-footer">
                        <div class="block">
                            <el-pagination
                                    layout="prev, pager, next"
                                    :total="totalPermissions">
                            </el-pagination>
                        </div>
                    </div>
                </div>
            </roles-details>
        </div>
    </div>
@stop