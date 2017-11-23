<template>
    <div class="panel panel-default">
        <el-row class="panel-header">
            <el-col :span="12" style="padding-left: 40px">
                <h4>Contacts</h4>
            </el-col>
            <el-col :span="12" style="text-align: right; padding-right: 40px">
                <button class="btn ebg-button" v-on:click="showReassignContactsDialog()" style="margin-right: 20px">
                    Reassign Contact
                </button>
                <button class="btn ebg-button" v-on:click="showAddDialog()">Add Contact</button>
            </el-col>
        </el-row>

        <el-row>
            <hr>
        </el-row>

        <div class="panel-body">

            <el-row :gutter="20">
                <el-form :model="searchForm" :rules="searchRules" ref="searchForm" label-position="top"
                         style="padding-left: 30px">

                    <el-col :span="2">
                        <el-form-item prop="filter" label="Filter By:">
                        </el-form-item>
                    </el-col>

                    <el-col :span="5">
                        <el-form-item prop="startDate" label="From date:">
                            <el-date-picker
                                    v-model="searchForm.startDate"
                                    type="date"
                                    placeholder="Start Date">
                            </el-date-picker>
                        </el-form-item>
                    </el-col>

                    <el-col :span="5">
                        <el-form-item prop="endDate" label="To date:">
                            <el-date-picker
                                    v-model="searchForm.endDate"
                                    type="date"
                                    placeholder="End Date">
                            </el-date-picker>
                        </el-form-item>
                    </el-col>

                    <el-col :span="5">
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

                    <el-col :span="5">
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

                    <el-col :span="2">
                        <el-form-item prop="search" style="margin-top: 30px">
                            <el-button type="primary" @click="searchContacts()">Search</el-button>
                        </el-form-item>
                    </el-col>

                </el-form>
            </el-row>

            <div class="col-lg-12">
                <hr>
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
                                close-transition>{{scope.row.status}}
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

            <el-dialog
                    title="New/Edit Contact"
                    :visible.sync="dialogVisible"
                    size="large">
                <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-position="left">

                    <div class="form-item-container">
                        <el-row :span="24" :gutter="20">
                            <el-col :span="2">
                                <span>Name: </span>
                            </el-col>
                            <el-col :span="2">
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
                            <el-col :span="7">
                                <el-form-item prop="firstname">
                                    <el-input placeholder="First Name" v-model="ruleForm.firstname"></el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :span="7">
                                <el-form-item prop="lastname">
                                    <el-input placeholder="Last Name" v-model="ruleForm.lastname"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>

                        <el-row :span="24" :gutter="20">
                            <el-col :span="2">
                                <span>Contact Details: </span>
                            </el-col>
                            <el-col :span="7">
                                <el-form-item prop="email">
                                    <el-input placeholder="Email (email@eminent.co.ke)"
                                              v-model="ruleForm.email"></el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :span="7">
                                <el-form-item prop="phone">
                                    <el-input placeholder="Phone Number" v-model.number="ruleForm.phone"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>

                        <el-row :span="24" :gutter="20">
                            <el-col :span="2">
                                <span>Other Details: </span>
                            </el-col>

                            <el-row :span="24" :gutter="20">
                                <el-col :span="7">
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
                                <el-col :span="7">
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

                            <el-col :span="2">
                                <span></span>
                            </el-col>

                            <el-row :span="24" :gutter="20">

                                <el-col :span="7">
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

                                <el-col :span="7">
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
                        </el-row>


                        <el-row :span="24" :gutter="20">
                            <el-col :span="2">
                                <span>Country: </span>
                            </el-col>
                            <el-col :span="7">
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
                            <el-col :span="2">
                                <span>Services</span>
                            </el-col>
                            <el-col :span="14">
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
                            <el-col :span="2">
                                <span>Address</span>
                            </el-col>
                            <el-col :span="14">
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
                    size="small">
                <el-form :model="reassignForm" :rules="reassignRules" ref="reassignForm" label-position="top">
                    <el-row :span="24" :gutter="20" style="margin-bottom: 10px">
                        <el-col :span="4">
                            <span>User Name: </span>
                        </el-col>

                        <el-col :span="20">
                            <span>{{ selectedUser.name }}</span>
                        </el-col>
                    </el-row>

                    <el-row :span="24" :gutter="20" style="margin-bottom: 10px">
                        <el-col :span="4">
                            <span>Email: </span>
                        </el-col>

                        <el-col :span="20">
                            <span>{{ selectedUser.email }}</span>
                        </el-col>
                    </el-row>

                    <el-row :span="24" :gutter="20" style="margin-bottom: 10px">
                        <el-col :span="4">
                            <span>No of Contacts: </span>
                        </el-col>

                        <el-col :span="20">
                            <span> {{ tableData.length }}</span>
                        </el-col>
                    </el-row>

                    <el-row :span="24" :gutter="20" style="margin-bottom: 10px">
                        <el-col :span="4">
                            <span>Users: </span>
                        </el-col>

                        <el-col :span="14">
                            <el-form-item prop="reassign"
                                          label="Please select the users you wish to assign the contacts to:">
                                <multiselect
                                        v-model="reassignForm.users"
                                        :options="users"
                                        :multiple="true"
                                        track-by="id"
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
                            :total="total">
                    </el-pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';

    export default {
        props: ['userId'],
        components: {Multiselect},
        data() {
            return {
                tableData: [],
                genders: [],
                titles: [],
                countries: [],
                religions: [],
                professions: [],
                users: [],
                sources: [],
                statuses: [],
                services: [],
                selectedUser: [],
                options: [{
                    value: '1',
                    label: 'Active'
                }, {
                    value: '0',
                    label: 'Inactive'
                }],
                total: 0,
                dialogVisible: false,
                reassignContactsDialogVisible: false,
                contactId: null,
                searchForm: {
                    startDate: '',
                    endDate: '',
                    source: '',
                    status: '',
                },
                reassignForm: {
                    users: ''
                },
                reassignRules: {
                    users: [
                        {required: true, message: 'Please input select users', trigger: 'change', type: 'array'},
                    ],
                },
                searchRules: {
                    startDate: [
                        {required: false, message: 'Please input start date', trigger: 'blur', type: 'date'},
                    ],
                    endDate: [
                        {required: false, message: 'Please input end date', trigger: 'blur', type: 'date'},
                    ],
                    source: [
                        {required: false, message: 'Please select source', trigger: 'change'},
                    ],
                    status: [
                        {required: false, message: 'Please select status', trigger: 'change'},
                    ],
                },
                ruleForm: {
                    source: '',
                    designation: '',
                    active: '',
                    title: '',
                    gender: '',
                    firstname: '',
                    lastname: '',
                    email: '',
                    phone: '',
                    role: '',
                    department: '',
                    employmentDate: '',
                    country: '',
                    profession: '',
                    religion: '',
                    address: '',
                    service: ''
                },
                rules: {
                    startDate: [
                        {required: true, message: 'Please input start date', trigger: 'blur', type: 'date'},
                    ],
                    source: [
                        {required: true, message: 'Please select status', trigger: 'change', type: 'number'},
                    ],
                    designation: [
                        {required: true, message: 'Please input designation name', trigger: 'blur'},
                    ],
                    active: [
                        {required: true, message: 'Please select active status', trigger: 'change'},
                    ],
                    title: [
                        {required: true, message: 'Please select title', trigger: 'change', type: 'number'},
                    ],
                    gender: [
                        {required: true, message: 'Please select gender', trigger: 'change', type: 'number'},
                    ],
                    firstname: [
                        {required: true, message: 'Please input First name', trigger: 'blur'},
                    ],
                    lastname: [
                        {required: true, message: 'Please input Last name', trigger: 'blur'},
                    ],
                    email: [
                        {required: true, message: 'Please input email', trigger: 'blur', type: 'email'},
                    ],
                    phone: [
                        {required: true, message: 'Please input Phone Number', trigger: 'blur', type: 'integer'},
                    ],
                    country: [
                        {required: true, message: 'Please select country', trigger: 'change', type: 'number'},
                    ],
                    profession: [
                        {required: true, message: 'Please select profession', trigger: 'change', type: 'number'},
                    ],
                    religion: [
                        {required: true, message: 'Please select religion', trigger: 'change', type: 'number'},
                    ],
                    employmentDate: [
                        {required: true, message: 'Please input employment date', trigger: 'blur', type: 'date'},
                    ],
                    service: [
                        {required: true, message: 'Please select service', trigger: 'change', type: 'array'},
                    ],
                },
            }
        },
        created: function () {
            let vm = this;

            vm.getUserContacts();

            vm.getInformation();
        },

        methods: {
            handleClick() {
                console.log('click');
            },
            getInformation()
            {
                let vm = this;
                axios.get('/contacts/info/'+vm.userId)
                    .then(function (response) {
                        vm.services = response.data.services;
                        vm.countries = response.data.countries;
                        vm.titles = response.data.titles;
                        vm.sources = response.data.sources;
                        vm.genders = response.data.genders;
                        vm.religions = response.data.religions;
                        vm.professions = response.data.professions;
                        vm.users = response.data.users;
                        vm.selectedUser = response.data.selectedUser
                        vm.statuses = response.data.statuses
                    }).catch(function (error) {
                    console.log(error);
                })
            },
            getUserContacts()
            {
                let vm = this;
                axios.get('/api/contacts/user/'+vm.userId)
                    .then(function (response) {
                        if(response.data.success)
                        {
                            vm.tableData = response.data.contacts.data;
                            vm.total = response.data.contacts.last_page;
                        }
                        else
                        {
                            vm.$message({
                                type: 'error',
                                message: response.data.message,
                            });
                        }

                    }).catch(function (error) {
                    console.log(error);
                })
            },
            showAddDialog()
            {
                let vm = this;

                vm.dialogVisible = true;
            },
            handleClose(done) {
                this.$confirm('Are you sure to close this dialog?')
                    .then(_ => {
                        done();
                    })
                    .catch(_ => {
                    });
            },
            add(formName)
            {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        let vm = this;

                        vm.$message({
                            type: 'info',
                            message: 'Saving Contact'
                        });

                        axios.post('/contacts/save', {
                            type: 1,
                            title_id: vm.ruleForm.title,
                            firstname: vm.ruleForm.firstname,
                            lastname: vm.ruleForm.lastname,
                            email: vm.ruleForm.email,
                            phone: vm.ruleForm.phone,
                            profession_id: vm.ruleForm.profession,
                            country_id: vm.ruleForm.country,
                            religion_id: vm.ruleForm.religion,
                            gender_id: vm.ruleForm.gender,
                            source_id: vm.ruleForm.source,
                            address: vm.ruleForm.address,
                            services: vm.ruleForm.service,
                            contactId: vm.contactId
                        })
                            .then(function (response) {
                                vm.dialogVisible = false;

                                vm.getUserContacts();

                                if (response.data.success) {
                                    vm.$message({
                                        type: 'success',
                                        message: response.data.message
                                    });

                                    vm.$refs[formName].resetFields();
                                }
                                else {
                                    vm.$message({
                                        type: 'error',
                                        message: response.data.message
                                    });
                                }
                            }).catch(function (error) {
                            console.log(error);
                        });
                    } else {
                        return false;
                    }
                });
            },

            edit(contact)
            {
                let vm = this;

                vm.dialogVisible = true;

                vm.contactId = contact.contactId;

                vm.ruleForm.firstname = contact.firstName;

                vm.ruleForm.lastname = contact.lastName;

                vm.ruleForm.email = contact.email;

                vm.ruleForm.phone = contact.phone;

                vm.ruleForm.profession = contact.profession_id;

                vm.ruleForm.country = contact.country_id;

                vm.ruleForm.religion = contact.religion_id;

                vm.ruleForm.gender = contact.gender_id;

                vm.ruleForm.source = contact.source_id;

                vm.ruleForm.title = contact.title_id;
            },

            searchContacts()
            {
                    let vm = this;

                    vm.$message({
                        type: 'info',
                        message: 'Searching...'
                    });

                    axios.post('/contacts/search', {
                        startDate: vm.searchForm.startDate+"",
                        endDate: vm.searchForm.endDate+"",
                        source: vm.searchForm.source,
                        status: vm.searchForm.status,
                        userId: vm.userId,
                    })
                        .then(function (response) {

                            if (response.data.success) {
                                vm.$message({
                                    type: 'success',
                                    message: response.data.message
                                });

                                vm.tableData = response.data.contacts.data;
                                vm.total = response.data.contacts.last_page;

                                vm.$refs[formName].resetFields();
                            }
                            else {
                                vm.$message({
                                    type: 'error',
                                    message: response.data.message
                                });
                            }
                        }).catch(function (error) {
                        console.log(error);
                    });
            },

            filterTag(value, row) {
                return row.tag === value;
            },

            details(user)
            {
                window.location.href = '/contact/details/' + user.id;
            },

            customLabel (option) {
                return `${option.label}`
            },

            userLabel (option) {
                return `${option.name}`
            },

            showReassignContactsDialog()
            {
                let vm = this;

                vm.reassignContactsDialogVisible = true;
            },

            reassignContacts(formName)
            {
                console.log('here');

                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        let vm = this;

                        vm.$message({
                            type: 'info',
                            message: 'Reassigning Contacts'
                        });

                        axios.post('/contacts/reassign', {
                            user_id: vm.userId,
                            assigned: vm.reassignForm.users,
                            contacts: vm.tableData.length
                        })
                            .then(function (response) {

                                vm.getUserContacts();

                                if (response.data.success) {
                                    vm.$message({
                                        type: 'success',
                                        message: response.data.message
                                    });

                                    vm.reassignContactsDialogVisible = false;

                                    vm.$refs[formName].resetFields();
                                }
                                else {
                                    vm.$message({
                                        type: 'error',
                                        message: response.data.message
                                    });
                                }
                            }).catch(function (error) {
                            console.log(error);
                        });
                    } else {
                        return false;
                    }
                });
            }
        }
    }
</script>

<style>
    .el-table {
        border-left: none;
        border-right: none;
    }

    .el-date-editor.el-input {
        width: 100%;
    }

    .el-select {
        width: 100%;
    }

    .el-input__inner {
        border: 1px solid #b4b4b4;
    }

    .el-input__icon {
        color: #b4b4b4 !important;
    }

    .search-container {
        padding-bottom: 20px;
        border-bottom: 1px solid;
        margin-bottom: 20px;
    }

    label {
        font-weight: normal
    }

    .el-table::after {
        width: 0px;
    }
</style>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>