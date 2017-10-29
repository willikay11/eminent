<template>
    <div class="panel panel-default">
        <div class="col-lg-12 panel-header">
            <div class="col-lg-6">
                <h4>Users</h4>
            </div>
            <div class="col-lg-6" style="text-align: right">
                <button class="btn ebg-button" v-on:click="showAddUserDialog()">Add User</button>
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
                                close-transition>{{scope.row.active}}</el-tag>
                    </template>
                </el-table-column>
                <el-table-column
                        label="Actions"
                        width="120">
                    <template slot-scope="scope">
                        <el-button @click="EditUser(scope.row)" size="small">Edit</el-button>
                    </template>
                </el-table-column>
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

                    <el-form-item label="Role" required>
                        <el-col :span="3" class="right-margin">
                            <el-form-item prop="role">
                                <el-select v-model="ruleForm.role" placeholder="Select Role">
                                    <el-option
                                            v-for="item in roles"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
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
</template>

<script>
    export default {
        data() {
            return {
                tableData: [],
                options: [{
                    value: '1',
                    label: 'Active'
                }, {
                    value: '0',
                    label: 'Inactive'
                }],
                genders: [],
                titles:[],
                departments: [],
                countries: [],
                designations: [],
                roles: [],
                total: 0,
                dialogVisible: false,
                userId: null,
                ruleForm: {
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
                },
                rules: {
                    designation : [
                        {required: true, message: 'Please input designation name', trigger: 'blur'},
                    ],
                    active : [
                        {required: true, message: 'Please select active status', trigger: 'change'},
                    ],
                    title : [
                        {required: true, message: 'Please select title', trigger: 'change'},
                    ],
                    gender : [
                        {required: true, message: 'Please select gender', trigger: 'change'},
                    ],
                    firstname : [
                        {required: true, message: 'Please input First name', trigger: 'blur'},
                    ],
                    lastname : [
                        {required: true, message: 'Please input Last name', trigger: 'blur'},
                    ],
                    email : [
                        {required: true, message: 'Please input email', trigger: 'blur', type: 'email'},
                    ],
                    phone : [
                        {required: true, message: 'Please input Phone Number', trigger: 'blur', type: 'number'},
                    ],
                    role : [
                        {required: true, message: 'Please select role', trigger: 'change'},
                    ],
                    department : [
                        {required: true, message: 'Please select department', trigger: 'change'},
                    ],
                    country : [
                        {required: true, message: 'Please select country', trigger: 'change'},
                    ],
                    employmentDate : [
                        {required: true, message: 'Please input employment date', trigger: 'blur', type: 'date'},
                    ],
                }
            }
        },
        created: function () {
            let vm = this;

            vm.getUsers();

            vm.getInformation();
        },

        methods:{
            handleClick() {
                console.log('click');
            },
            getUsers()
            {
                let vm = this;
                axios.get('/api/users')
                    .then(function (response) {
                        vm.tableData = [].concat(response.data.data);
                        vm.total = response.data.last_page;
                    }).catch(function (error) {
                    console.log(error);
                })
            },
            getInformation()
            {
                let vm = this;
                axios.get('/info/users')
                    .then(function (response) {
                        vm.departments = response.data.departments;
                        vm.designations = response.data.designations;
                        vm.countries = response.data.countries;
                        vm.titles = response.data.titles;
                        vm.roles = response.data.roles;
                        vm.genders = response.data.genders;
                    }).catch(function (error) {
                    console.log(error);
                })
            },
            showAddUserDialog()
            {
                let vm = this;

                vm.dialogVisible = true;
            },
            handleClose(done) {
                this.$confirm('Are you sure to close this dialog?')
                    .then(_ => {
                        done();
                    })
                    .catch(_ => {});
            },
            addUser(formName)
            {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        let vm = this;
                        axios.post('/users/save', {
                            type: 1,
                            title_id: vm.ruleForm.title,
                            firstname     : vm.ruleForm.firstname,
                            lastname : vm.ruleForm.lastname,
                            email: vm.ruleForm.email,
                            phone: vm.ruleForm.phone,
                            gender_id: vm.ruleForm.gender,
                            country_id: vm.ruleForm.country,
                            designation_id: vm.ruleForm.designation,
                            department_id: vm.ruleForm.department,
                            role_id: vm.ruleForm.role,
                            active: 0,
                            userId: vm.userId,
                            employment_date: vm.ruleForm.employmentDate
                        })
                            .then(function (response)
                            {
                                vm.dialogVisible = false;

                                vm.getUsers();

                                if(response.data.success)
                                {
                                    vm.$message({
                                        type: 'success',
                                        message: response.data.message
                                    });

                                    vm.$refs[formName].resetFields();
                                }
                                else
                                {
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
            EditUser(user)
            {
                let vm = this;

                vm.dialogVisible = true;

//                vm.ruleForm.designationName = designation.name;
//
                vm.ruleForm.designation = user.designation_id;
            },
            filterTag(value, row) {
                return row.tag === value;
            }
        }
    }
</script>

<style>
    .el-table{
        border-left: none;
        border-right: none;
    }
    .hr-section-divider{
        border: 1px solid #F1F1F1;
        width: 80%;
        margin-top: 10px;
        margin-bottom: 0px;
        margin-left: 20px;
        display: inline-block;
    }
    .contact-add{
        padding-top: 15px;
        padding-bottom: 15px;
    }

    .form-item-container{
        padding-right: 100px;
        padding-left: 30px;
    }
    .right-margin{
        margin-right: 20px;
    }
</style>