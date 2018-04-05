@extends('dashboard.default')


@section('main-content')

    <section class="content-header">
        <h1>
            Team Members List
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/team"><i class=""></i> Team</a></li>
            <li class="active">Team Members</li>
        </ol>
    </section>

    <section class="content">
        <team-member-table team-id="{!! $team->id !!}" team-name="{!! $team->name !!}" inline-template>
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <div class="pull-left">
                                <h3 class="box-title" style="padding-bottom: 25px">@{{ teamName }}</h3>
                            </div>

                            <div class="pull-right box-tools">
                                <div class="col-lg-6" style="text-align: right">
                                        @if(in_array(19, getPermissions()))
                                            <el-button type="primary" plain icon="el-icon-plus" v-on:click="showAddTeamMemberDialog()">Add Members</el-button>
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
                                    prop="email"
                                    label="Email">
                            </el-table-column>
                            @if(in_array(19, getPermissions()))
                                <el-table-column
                                        label="Actions">
                                    <template slot-scope="scope">
                                        <el-button @click="removeTeamMember(scope.row)" size="small">Remove</el-button>
                                        <el-button @click="contacts(scope.row)"size="small">Contacts</el-button>
                                        <el-button @click="interactions(scope.row)"size="small">Interactions</el-button>
                                        <el-button @click="activities(scope.row)"size="small">Activities</el-button>
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
                                title="Add Team Member"
                                :visible.sync="dialogVisible"
                                size="tiny">
                            <el-form label-position="top">

                                <el-form-item prop="teamMembers" label="Team Members">
                                    <multiselect
                                            v-model="selectedUsers"
                                            :options="users"
                                            :multiple="true"
                                            track-by="value"
                                            :custom-label="userName">
                                    </multiselect>
                                </el-form-item>

                            </el-form>
                            <span slot="footer" class="dialog-footer">
                <el-button @click="dialogVisible = false">Cancel</el-button>
                                <el-button type="primary" @click="addTeamMembers">Save</el-button>
            </span>
                        </el-dialog>

                    </div>
                </div>
            </div>
        </team-member-table>
    </section>
@stop