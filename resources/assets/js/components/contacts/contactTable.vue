<template>
    <div class="panel panel-default">
        <div class="col-lg-12 panel-header">
            <div class="col-lg-6">
                <h4>Contacts</h4>
            </div>
            <div class="col-lg-6" style="text-align: right">
                <button class="btn ebg-button" v-on:click="showAddDialog()" style="margin-right: 20px">Reasign Contact
                </button>
                <button class="btn ebg-button" v-on:click="showAddDialog()">Add Contact</button>
            </div>
            <div class="col-lg-12">
                <hr>
            </div>
        </div>

        <div class="panel-body">

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
                                    v-for="item in sources"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-col>

            </el-form>

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
                                <span>Products</span>
                            </el-col>
                            <el-col :span="14">
                                <el-form-item prop="email">
                                    <el-input placeholder="Email (email@eminent.co.ke)"
                                              v-model="ruleForm.email"></el-input>
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
    export default {
        data() {
            return {
                tableData: [],
                genders: [],
                titles: [],
                countries: [],
                religions: [],
                professions: [],
                sources: [],
                services: [],
                options: [{
                    value: '1',
                    label: 'Active'
                }, {
                    value: '0',
                    label: 'Inactive'
                }],
                total: 0,
                dialogVisible: false,
                contactId: null,
                searchForm: {
                    startDate: '',
                    endDate: '',
                    source: '',
                    status: '',
                },
                searchRules: {
                    startDate: [
                        {required: true, message: 'Please input start date', trigger: 'blur', type: 'date'},
                    ],
                    endDate: [
                        {required: true, message: 'Please input end date', trigger: 'blur', type: 'date'},
                    ],
                    source: [
                        {required: true, message: 'Please select source', trigger: 'change'},
                    ],
                    status: [
                        {required: true, message: 'Please select status', trigger: 'change'},
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
                    address: ''
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
                axios.get('/contacts/info')
                    .then(function (response) {
                        vm.services = response.data.services;
                        vm.countries = response.data.countries;
                        vm.titles = response.data.titles;
                        vm.sources = response.data.sources;
                        vm.genders = response.data.genders;
                        vm.religions = response.data.religions;
                        vm.professions = response.data.professions;
                    }).catch(function (error) {
                    console.log(error);
                })
            },
            getUserContacts()
            {
                let vm = this;
                axios.get('/api/contacts/user')
                    .then(function (response) {
                        vm.tableData = [].concat(response.data.data);
                        vm.total = response.data.last_page;
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

                        console.log(vm.ruleForm.phone);

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

                console.log(contact);

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
            filterTag(value, row) {
                return row.tag === value;
            },
            details(user)
            {
                window.location.href = '/contact/details/' + user.id;
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