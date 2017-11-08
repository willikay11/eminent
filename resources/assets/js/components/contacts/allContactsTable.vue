<template>
    <div class="panel panel-default">
        <div class="col-lg-12 panel-header">
            <div class="col-lg-6">
                <h4>Contacts</h4>
            </div>
            <div class="col-lg-6" style="text-align: right">
            </div>
            <div class="col-lg-12">
                <hr>
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
                                :type="scope.row.clientExists === 1 ? 'success' : 'warning'"
                                close-transition>{{scope.row.status}}
                        </el-tag>
                    </template>
                </el-table-column>
                <el-table-column
                        label="Actions">
                    <template slot-scope="scope">
                        <el-button @click="details(scope.row)" size="small">Details</el-button>
                    </template>
                </el-table-column>
            </el-table>

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
                users: [],
                sources: [],
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

            vm.geContacts();
        },

        methods: {
            handleClick() {
                console.log('click');
            },
            geContacts()
            {
                let vm = this;
                axios.get('/api/contacts')
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
            details(user)
            {
                window.location.href = '/contact/details/' + user.id;
            },
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