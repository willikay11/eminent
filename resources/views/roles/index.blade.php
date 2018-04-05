@extends('dashboard.default')


@section('main-content')

    <section class="content-header">
        <h1>
            Roles List
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Roles</li>
        </ol>
    </section>

    <section class="content">
        <roles-table inline-template>
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <div class="pull-left">
                                <h3 class="box-title" style="padding-bottom: 25px">Roles</h3>
                            </div>

                            <div class="pull-right box-tools">
                                <div class="col-lg-6" style="text-align: right">
                                    @if(in_array(15, getPermissions()))
                                        <el-button type="primary" plain icon="el-icon-plus" v-on:click="showAddRoleDialog()">Add Role</el-button>
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
                                    prop="tag"
                                    label="Active">
                                <template slot-scope="scope">
                                    <el-tag
                                            :type="scope.row.active === 'Active' ? 'success' : 'danger'"
                                            close-transition>@{{scope.row.active}}</el-tag>
                                </template>
                            </el-table-column>
                            @if(in_array(15, getPermissions()))
                                <el-table-column
                                        label="Actions"
                                        width="120">
                                    <template slot-scope="scope">
                                        <el-button @click="showDetails(scope.row)" size="small">Details</el-button>
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

                        <el-dialog
                                title="Tips"
                                :visible.sync="dialogVisible"
                                size="tiny">
                            <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-position="top">

                                <el-form-item prop="roleName" label="Role Name">
                                    <el-input placeholder="Input Name" v-model="ruleForm.roleName"></el-input>
                                </el-form-item>

                                <el-form-item prop="roleDescription" label="Description">
                                    <el-input placeholder="Input Description" v-model="ruleForm.roleDescription"></el-input>
                                </el-form-item>
                            </el-form>
                            <span slot="footer" class="dialog-footer">
                                <el-button @click="dialogVisible = false">Cancel</el-button>
                                <el-button type="primary" @click="addRole('ruleForm')">Save</el-button>
                            </span>
                        </el-dialog>

                    </div>
                </div>
            </div>
        </roles-table>
    </section>
@stop