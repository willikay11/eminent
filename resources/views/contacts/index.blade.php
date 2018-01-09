@extends('dashboard.default')


@section('dashboard-content')

    <div class="row">
        <div class="col-lg-12">
            <contacts-table user-id="{!! $userId !!}" inline-template>
                <div class="panel panel-default contact-panel">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 panel-header">
                            <div class="col-lg-6 col-md-3 col-sm-3 col-xs-2">
                                <h4>Contacts</h4>
                            </div>
                            <div class="col-lg-6 col-md-9 col-sm-9 col-xs-10" style="text-align: right;">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    @if(in_array(6, getPermissions()))
                                        <button class="btn ebg-button" v-on:click="showAddDialog()">Add Contact</button>
                                    @endif
                                </div>

                                @if(in_array(7, getPermissions()))
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <button class="btn ebg-button" v-if="selectedUsersForReassign.length != 0" v-on:click="showReassignContactsDialog()" style="margin-right: 20px">
                                            Reassign Contact
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <hr>
                        </div>
                    </div>

                    <div class="panel-body">

                        <el-row :xs="24" :sm="24" :md="24" :lg="24" :gutter="20">
                            <el-form :model="searchForm" :rules="searchRules" ref="searchForm" label-position="top"
                                     style="padding-left: 30px">

                                <el-col :xs="24" :sm="24" :md="24" :lg="2">
                                    <el-form-item prop="filter" label="Filter By:">
                                    </el-form-item>
                                </el-col>

                                <el-col :xs="12" :sm="12" :md="6" :lg="4">
                                    <el-form-item prop="startDate" label="From date:">
                                        <el-date-picker
                                                v-model="searchForm.startDate"
                                                type="date"
                                                placeholder="Start Date">
                                        </el-date-picker>
                                    </el-form-item>
                                </el-col>

                                <el-col :xs="12" :sm="12" :md="6" :lg="4">
                                    <el-form-item prop="endDate" label="To date:">
                                        <el-date-picker
                                                v-model="searchForm.endDate"
                                                type="date"
                                                placeholder="End Date">
                                        </el-date-picker>
                                    </el-form-item>
                                </el-col>

                                <el-col :xs="12" :sm="12" :md="6" :lg="4">
                                    <el-form-item prop="source" label="Source:">
                                        <el-select v-model="searchForm.source" placeholder="Select source">
                                            <el-option
                                                    v-for="item in sources"
                                                    :key="item.value"
                                                    :label="item.label"
                                                    :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </el-form-item>
                                </el-col>

                                <el-col :xs="12" :sm="12" :md="6" :lg="4">
                                    <el-form-item prop="source" label="Status:">
                                        <el-select v-model="searchForm.status" placeholder="Select status">
                                            <el-option
                                                    v-for="item in statuses"
                                                    :key="item.value"
                                                    :label="item.label"
                                                    :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </el-form-item>
                                </el-col>

                                @if(in_array(5, getPermissions()))
                                    <el-col :xs="12" :sm="12" :md="6" :lg="4">
                                        <el-form-item prop="users" label="Users:">
                                            <el-select v-model="searchForm.user" placeholder="Select User">
                                                <el-option
                                                        v-for="item in allUsers"
                                                        :key="item.value"
                                                        :label="item.label"
                                                        :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </el-form-item>
                                    </el-col>
                                @endif()

                                <el-col :xs="6" :sm="6" :md="3" :lg="2">
                                    <el-form-item prop="search" style="margin-top: 56px">
                                        <el-button type="primary" @click="searchContacts()">Search</el-button>
                                    </el-form-item>
                                </el-col>

                                <el-col :xs="6" :sm="6" :md="3" :lg="2">
                                    <el-form-item prop="search" style="margin-top: 56px; margin-left: 20px">
                                        @if(in_array(8, getPermissions()))
                                            <el-button type="primary" @click="exportContacts()">Export</el-button>
                                        @endif
                                    </el-form-item>
                                </el-col>
                            </el-form>
                        </el-row>

                        <div class="col-lg-12">
                            <hr>
                        </div>

                        <el-table
                                v-loading.body="tableLoading"
                                :data="tableData"
                                stripe
                                class="visible-lg visible-md"
                                style="width: 100%"
                                @selection-change="handleSelectionChange">
                            @if(in_array(7, getPermissions()))
                                <el-table-column
                                        type="selection"
                                        width="55">
                                </el-table-column>
                            @endif
                            <el-table-column
                                    prop="name"
                                    label="Name">
                            </el-table-column>
                            <el-table-column
                                    prop="email"
                                    label="Email">
                            </el-table-column>
                            <el-table-column
                                    prop="phone"
                                    label="Phone Number">
                            </el-table-column>
                            <el-table-column
                                    prop="source"
                                    label="Source">
                            </el-table-column>
                            <el-table-column
                                    prop="tag"
                                    label="Status">
                                <template slot-scope="scope">
                                    <el-tag
                                            :type="scope.row.status === 'Client' ? 'success' : scope.row.status === 'Prospect' ? 'warning' : 'danger'"
                                            close-transition>@{{scope.row.status}}
                                    </el-tag>
                                </template>
                            </el-table-column>
                            <el-table-column
                                    label="Actions">
                                <template slot-scope="scope">
                                    <el-button @click="edit(scope.row)" size="small">Edit</el-button>
                                    <el-button @click="details(scope.row)" size="small">Details</el-button>
                                </template>
                            </el-table-column>
                        </el-table>

                        <el-table
                                v-loading.body="tableLoading"
                                :data="tableData"
                                stripe
                                class="visible-sm visible-xs"
                                style="width: 100%"
                                @selection-change="handleSelectionChange">
                            @if(in_array(7, getPermissions()))
                                <el-table-column
                                        type="selection"
                                        width="55">
                                </el-table-column>
                            @endif
                            <el-table-column type="expand">
                                <template scope="scope">
                                    <p><strong>Email:</strong> @{{ scope.row.email }}</p>
                                    <p><strong>Phone:</strong> @{{ scope.row.phone }}</p>
                                    <p><strong>Source:</strong> @{{ scope.row.source }}</p>
                                    <p><strong>Status:</strong> <el-tag
                                                        :type="scope.row.status === 'Client' ? 'success' : scope.row.status === 'Prospect' ? 'warning' : 'danger'"
                                                        close-transition>@{{scope.row.status}}
                                                </el-tag></p>
                                </template>
                            </el-table-column>
                            <el-table-column
                                    label="Name"
                                    prop="name">
                            </el-table-column>
                            <el-table-column
                                    label="Actions">
                                <template slot-scope="scope">
                                    <el-button @click="edit(scope.row)" size="small">Edit</el-button>
                                    <el-button @click="details(scope.row)" size="small">Details</el-button>
                                </template>
                            </el-table-column>
                        </el-table>

                        <el-dialog
                                title="New/Edit Contact"
                                :visible.sync="dialogVisible"
                                width="80%">
                            <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-position="left">

                                <div class="form-item-container">

                                    <el-row :span="24" :gutter="20" class="contact-type-container">
                                        <el-col :xs="24" :sm="24" :md="24" :lg="2">
                                            <span class="contact-type-span">Contact Type</span>
                                        </el-col>
                                        <el-col :xs="12" :sm="6" :md="6" :lg="3">
                                            <el-radio class="radio" v-model="type" label="1">Individual</el-radio>
                                        </el-col>
                                        <el-col :xs="12" :sm="6" :md="6" :lg="3">
                                            <el-radio class="radio" v-model="type" label="2">Organization</el-radio>
                                        </el-col>
                                    </el-row>

                                    <el-row :span="24" :gutter="20" v-if="type == 2" style="margin-bottom: 20px">
                                        <el-col :xs="24" :sm="24" :md="24" :lg="2">
                                            <span class="contact-type-span">Name</span>
                                        </el-col>
                                        <el-col :xs="22" :sm="22" :md="22" :lg="20">
                                            <el-input placeholder="Organization" v-model="ruleForm.organization"></el-input>
                                        </el-col>
                                    </el-row>

                                    <el-row :span="24" :gutter="20">
                                        <el-col :xs="24" :sm="24" :md="24" :lg="2" v-if="type == 1">
                                            <span>Name: </span>
                                        </el-col>
                                        <el-col :xs="24" :sm="24" :md="24" :lg="2" v-if="type == 2">
                                            <span>Contact Person: </span>
                                        </el-col>
                                        <el-col :xs="5" :sm="4" :md="4" :lg="4">
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
                                        <el-col  :xs="9" :sm="9" :md="9" :lg="8">
                                            <el-form-item prop="firstname">
                                                <el-input placeholder="First Name" v-model="ruleForm.firstname"></el-input>
                                            </el-form-item>
                                        </el-col>
                                        <el-col  :xs="9" :sm="9" :md="9" :lg="8">
                                            <el-form-item prop="lastname">
                                                <el-input placeholder="Last Name" v-model="ruleForm.lastname"></el-input>
                                            </el-form-item>
                                        </el-col>
                                    </el-row>

                                    <el-row :span="24" :gutter="20">
                                        <el-col :xs="24" :sm="24" :md="24" :lg="2">
                                            <span>Contact Details: </span>
                                        </el-col>
                                        <el-col :xs="12" :sm="11" :md="11" :lg="10">
                                            <el-form-item prop="email">
                                                <el-input placeholder="Email (email@eminent.co.ke)"
                                                          v-model="ruleForm.email"></el-input>
                                            </el-form-item>
                                        </el-col>
                                        <el-col :xs="11" :sm="11" :md="11" :lg="10">
                                            <el-form-item prop="phone">
                                                <el-input placeholder="Phone Number" v-model.number="ruleForm.phone"></el-input>
                                            </el-form-item>
                                        </el-col>
                                    </el-row>

                                    <el-row :span="24" :gutter="20">
                                        <el-col :xs="24" :sm="24" :md="24" :lg="2">
                                            <span>Other Details: </span>
                                        </el-col>

                                            <el-col :xs="11" :sm="11" :md="11" :lg="10">
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
                                            <el-col :xs="11" :sm="11" :md="11" :lg="10">
                                                <el-form-item prop="source">
                                                    <el-select v-model="ruleForm.source" filterable placeholder="Select Source">
                                                        <el-option
                                                                v-for="item in sources"
                                                                :key="item.value"
                                                                :label="item.label"
                                                                :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </el-form-item>
                                            </el-col>
                                    </el-row>

                                    <el-row :span="24" :gutter="20">
                                        <el-col :xs="24" :sm="24" :md="24" :lg="2">
                                            <span></span>
                                        </el-col>

                                            <el-col  :xs="11" :sm="11" :md="11" :lg="10">
                                                <el-form-item prop="profession">
                                                    <el-select v-model="ruleForm.profession" filterable
                                                               placeholder="Select Profession">
                                                        <el-option
                                                                v-for="item in professions"
                                                                :key="item.value"
                                                                :label="item.label"
                                                                :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </el-form-item>
                                            </el-col>

                                            <el-col  :xs="11" :sm="11" :md="11" :lg="10">
                                                <el-form-item prop="religion">
                                                    <el-select v-model="ruleForm.religion" filterable placeholder="Select Religion">
                                                        <el-option
                                                                v-for="item in religions"
                                                                :key="item.value"
                                                                :label="item.label"
                                                                :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </el-form-item>
                                            </el-col>
                                    </el-row>

                                    <el-row :span="24" :gutter="20">
                                        <el-col :xs="24" :sm="24" :md="24" :lg="2">
                                            <span>Country: </span>
                                        </el-col>
                                        <el-col :xs="22" :sm="22" :md="22" :lg="20">
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
                                    </el-row>

                                    <el-row :span="24" :gutter="20">
                                        <el-col :xs="24" :sm="24" :md="24" :lg="2">
                                            <span>Services</span>
                                        </el-col>
                                        <el-col :xs="22" :sm="22" :md="22" :lg="20">
                                            <el-form-item prop="service">
                                                <multiselect
                                                        v-model="ruleForm.service"
                                                        :options="services"
                                                        :multiple="true"
                                                        track-by="value"
                                                        :custom-label="customLabel">
                                                </multiselect>
                                            </el-form-item>
                                        </el-col>
                                    </el-row>

                                    <el-row :span="24" :gutter="20">
                                        <el-col :xs="24" :sm="24" :md="24" :lg="2">
                                            <span>Address</span>
                                        </el-col>
                                        <el-col :xs="22" :sm="22" :md="22" :lg="20">
                                            <el-form-item prop="addres">
                                                <el-input placeholder="Address"
                                                          type="textarea"
                                                          :rows="3"
                                                          v-model="ruleForm.address"></el-input>
                                            </el-form-item>
                                        </el-col>
                                    </el-row>
                                </div>

                                <hr>

                            </el-form>

                            <div class="form-item-container">
                    <span slot="footer" class="dialog-footer">
                        <el-button @click="dialogVisible = false">Cancel</el-button>
                        <el-button type="primary" class="btn ebg-button" @click="add('ruleForm')">Save</el-button>
                    </span>
                            </div>
                        </el-dialog>

                        <el-dialog
                                title="Assign User Contacts"
                                :visible.sync="reassignContactsDialogVisible"
                                width="70%">
                            <el-form :model="reassignForm" :rules="reassignRules" ref="reassignForm" label-position="top">
                                <el-row :span="24" :gutter="20" style="margin-bottom: 10px">
                                    <el-col :xs="4" :sm="4" :md="4" :lg="4">
                                        <span>User Name: </span>
                                    </el-col>

                                    <el-col :xs="20" :sm="20" :md="20" :lg="20">
                                        <span>@{{ selectedUser.name }}</span>
                                    </el-col>
                                </el-row>

                                <el-row :span="24" :gutter="20" style="margin-bottom: 10px">
                                    <el-col :xs="4" :sm="4" :md="4" :lg="4">
                                        <span>Email: </span>
                                    </el-col>

                                    <el-col :xs="20" :sm="20" :md="20" :lg="20">
                                        <span>@{{ selectedUser.email }}</span>
                                    </el-col>
                                </el-row>

                                <el-row :span="24" :gutter="20" style="margin-bottom: 10px">
                                    <el-col :xs="4" :sm="4" :md="4" :lg="4">
                                        <span>No of Contacts: </span>
                                    </el-col>

                                    <el-col :xs="20" :sm="20" :md="20" :lg="20">
                                        <span>@{{ selectedUsersForReassign.length }}</span>
                                    </el-col>
                                </el-row>

                                <el-row :span="24" :gutter="20" style="margin-bottom: 10px">
                                    <el-col :xs="4" :sm="4" :md="4" :lg="4">
                                        <span>Users: </span>
                                    </el-col>

                                    <el-col :xs="20" :sm="20" :md="20" :lg="20">
                                        <el-form-item prop="reassign"
                                                      label="Please select the users you wish to assign the contacts to:">
                                            <multiselect
                                                    v-model="reassignForm.users"
                                                    :options="users"
                                                    :multiple="true"
                                                    track-by="value"
                                                    :custom-label="userLabel">
                                            </multiselect>
                                        </el-form-item>
                                    </el-col>
                                </el-row>

                                <hr style="margin-top: 0px">

                            </el-form>

                            <div class="form-item-container">
                    <span slot="footer" class="dialog-footer">
                        <el-button @click="dialogVisible = false">Cancel</el-button>
                        <el-button type="primary" class="btn ebg-button" @click="reassignContacts('reassignForm')">Reassign</el-button>
                    </span>
                            </div>
                        </el-dialog>

                        <hr class="panel-hr">

                        <div class="panel-footer">
                            <div class="block">
                                <el-pagination
                                        layout="prev, pager, next"
                                        @current-change="handleCurrentChange"
                                        :total="total">
                                </el-pagination>
                            </div>
                        </div>
                    </div>
                </div>
            </contacts-table>
        </div>
    </div>
@stop