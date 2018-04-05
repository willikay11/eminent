@extends('dashboard.default')


@section('main-content')

    <section class="content-header">
        <h1>
            Team List
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Team</li>
        </ol>
    </section>

    <section class="content">
        <team-table inline-template>
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <div class="pull-left">
                                <h3 class="box-title" style="padding-bottom: 25px">Teams</h3>
                            </div>

                            <div class="pull-right box-tools">
                                <div class="col-lg-6" style="text-align: right">
                                    @if(in_array(19, getPermissions()))
                                        <el-button type="primary" plain icon="el-icon-plus" v-on:click="showAddTeamDialog()">Add Team</el-button>
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
                                    prop="head"
                                    label="Team Head">
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
                            @if(in_array(19, getPermissions()))
                                <el-table-column
                                        label="Actions">
                                    <template slot-scope="scope">
                                        <el-button @click="EditTeam(scope.row)" size="small">Edit</el-button>
                                        <el-button @click="members(scope.row)" size="small">Members</el-button>
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
                                title="New/Edit Team"
                                :visible.sync="dialogVisible"
                                size="tiny">
                            <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-position="top">

                                <el-form-item prop="teamName" label="Team Name">
                                    <el-input placeholder="Input Name" v-model="ruleForm.teamName"></el-input>
                                </el-form-item>

                                <el-form-item prop="user" label="Users">
                                    <el-select v-model="ruleForm.user" placeholder="Select user">
                                        <el-option
                                                v-for="item in users"
                                                :key="item.value"
                                                :label="item.label"
                                                :value="item.value">
                                        </el-option>
                                    </el-select>
                                </el-form-item>

                                <el-form-item prop="active" label="Active">
                                    <el-select v-model="ruleForm.active" placeholder="Select">
                                        <el-option
                                                v-for="item in options"
                                                :key="item.value"
                                                :label="item.label"
                                                :value="item.value">
                                        </el-option>
                                    </el-select>
                                </el-form-item>
                            </el-form>
                            <span slot="footer" class="dialog-footer">
                <el-button @click="dialogVisible = false">Cancel</el-button>
                                <el-button type="primary" @click="addTeam('ruleForm')">Save</el-button>
            </span>
                        </el-dialog>

                    </div>
                </div>
            </div>
        </team-table>
    </section>
@stop