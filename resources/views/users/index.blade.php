@extends('dashboard.default')


@section('dashboard-content')

    <div class="row">
        <div class="col-lg-12">
            <users-table inline-template>
                <div class="panel panel-default">
                    <div class="col-lg-12 panel-header">
                        <div class="col-lg-6">
                            <h4>Users</h4>
                        </div>
                        <div class="col-lg-6" style="text-align: right">
                            @if(in_array(1, getPermissions()))
                                <button class="btn ebg-button" v-on:click="showAddUserDialog()">Add User</button>
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
                            <el-table-column
                                    prop="role"
                                    label="Role">
                            </el-table-column>
                            <el-table-column
                                    prop="phone"
                                    label="Phone Number">
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
                            @if(in_array(1, getPermissions()))
                                <el-table-column
                                        label="Actions">
                                    <template slot-scope="scope">
                                        <el-button @click="EditUser(scope.row)" size="small">Edit</el-button>
                                        <el-button @click="UserRole(scope.row)" size="small">Roles</el-button>
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
                            title="New/Edit User"
                            :visible.sync="dialogVisible"
                            size="large">
                        <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-position="left">

                            <div class="contact-add">
                                <span>Personal Details</span>
                                <hr class="hr-section-divider">
                            </div>

                            <div class="form-item-container">
                                <el-form-item label="Title & Name" required>
                                    <el-col :span="3" class="right-margin">
                                        <el-form-item prop="title">
                                            <el-select v-model="ruleForm.title" placeholder="Select Title">
                                                <el-option
                                                        v-for="item in titles"
                                                        :key="item.value"
                                                        :label="item.label"
                                                        :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :span="7" class="right-margin">
                                        <el-form-item prop="firstname">
                                            <el-input placeholder="First Name" v-model="ruleForm.firstname"></el-input>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :span="7">
                                        <el-form-item prop="lastname">
                                            <el-input placeholder="Last Name" v-model="ruleForm.lastname"></el-input>
                                        </el-form-item>
                                    </el-col>
                                </el-form-item>

                                <el-form-item label="Gender & Country" required>
                                    <el-col :span="3" class="right-margin">
                                        <el-form-item prop="gender">
                                            <el-select v-model="ruleForm.gender" placeholder="Select Gender">
                                                <el-option
                                                        v-for="item in genders"
                                                        :key="item.value"
                                                        :label="item.label"
                                                        :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :span="3">
                                        <el-form-item prop="country">
                                            <el-select v-model="ruleForm.country" filterable placeholder="Select Country">
                                                <el-option
                                                        v-for="item in countries"
                                                        :key="item.value"
                                                        :label="item.label"
                                                        :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </el-form-item>
                                    </el-col>
                                </el-form-item>

                                <el-form-item label="Email & Phone" required>
                                    <el-col :span="7" class="right-margin">
                                        <el-form-item prop="email">
                                            <el-input placeholder="Email (email@eminent.co.ke)" v-model="ruleForm.email"></el-input>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :span="7">
                                        <el-form-item prop="phone">
                                            <el-input placeholder="Phone Number" v-model.number="ruleForm.phone"></el-input>
                                        </el-form-item>
                                    </el-col>
                                </el-form-item>

                            </div>

                            <div class="contact-add">
                                <span>User Details</span>
                                <hr class="hr-section-divider">
                            </div>

                            <div class="form-item-container">
                                <el-form-item label="Department" required>
                                    <el-form-item prop="department">
                                        <el-select v-model="ruleForm.department" placeholder="Select Department">
                                            <el-option
                                                    v-for="item in departments"
                                                    :key="item.value"
                                                    :label="item.label"
                                                    :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </el-form-item>
                                </el-form-item>

                                <el-form-item prop="roles"
                                              label="Role">
                                    <el-col :span="6">
                                        <multiselect
                                                v-model="ruleForm.role"
                                                :options="roles"
                                                :multiple="true"
                                                track-by="value"
                                                :custom-label="userRole">
                                        </multiselect>
                                    </el-col>
                                </el-form-item>

                                <el-form-item label="Employment Date" required>
                                    <el-col :span="7">
                                        <el-form-item prop="employmentDate">
                                            <el-date-picker
                                                    v-model="ruleForm.employmentDate"
                                                    type="date"
                                                    placeholder="Employment Date">
                                            </el-date-picker>
                                        </el-form-item>
                                    </el-col>
                                </el-form-item>

                                <el-form-item label="Designation" required>
                                    <el-form-item prop="designation">
                                        <el-select v-model="ruleForm.designation" placeholder="Select Designation">
                                            <el-option
                                                    v-for="item in designations"
                                                    :key="item.value"
                                                    :label="item.label"
                                                    :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </el-form-item>
                                </el-form-item>
                            </div>

                            <hr>

                        </el-form>
                        <div class="form-item-container">
                <span slot="footer" class="dialog-footer">
                    <el-button @click="dialogVisible = false">Cancel</el-button>
                    <el-button type="primary" @click="addUser('ruleForm')">Save</el-button>
                </span>
                        </div>
                    </el-dialog>
                </div>
            </users-table>
        </div>
    </div>
@stop