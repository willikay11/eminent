@extends('dashboard.default')


@section('dashboard-content')

    <div class="row">
        <div class="col-lg-12">
            <team-member-table team-id="{!! $team->id !!}" team-name="{!! $team->name !!}" inline-template>
                <div class="panel panel-default">
                    <div class="col-lg-12 panel-header">
                        <div class="col-lg-6">
                            <h4>@{{ teamName }}</h4>
                        </div>
                        <div class="col-lg-6" style="text-align: right">
                            @if(in_array(19, getPermissions()))
                                <button class="btn ebg-button" v-on:click="showAddTeamMemberDialog()">Add Members</button>
                            @endif
                        </div>
                    </div>
                    <div class="panel-body">
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
            </team-member-table>
        </div>
    </div>
@stop