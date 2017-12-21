<template></template>

<script>
    import Multiselect from 'vue-multiselect';

    import moment from 'moment';

    export default {
        props: ['userId'],
        components: {Multiselect},
        data() {
            return {
                tableLoading: true,
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
                allUsers: [],
                selectedUsersForReassign: [],
                type: '1',
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
                    user: ''
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
                    service: '',
                    organization: ''
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
                        vm.selectedUser = response.data.selectedUser;
                        vm.statuses = response.data.statuses;
                        vm.allUsers = response.data.allUsers;
                    }).catch(function (error) {
                    console.log(error);
                })
            },

            getUserContacts(page = null)
            {
                let vm = this;

                vm.tableLoading = true;

                let url = '/api/contacts/user/'+vm.userId;

                if (page != null)
                {
                    url = '/api/contacts/user/'+vm.userId+'/?page='+page
                }

                axios.get(url)
                    .then(function (response) {
                        if(response.data.success)
                        {
                            vm.tableData = response.data.contacts.data;
                            vm.total = response.data.contacts.last_page * 10;
                            vm.tableLoading = false;
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

            handleClose(done)
            {
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
                            type: vm.type,
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
                            contactId: vm.contactId,
                            organization: vm.ruleForm.organization,
                        })
                            .then(function (response) {

                                if (response.data.success) {

                                    vm.dialogVisible = false;

                                    vm.getUserContacts();

                                    vm.$message({
                                        type: 'success',
                                        message: response.data.message
                                    });

                                    vm.ruleForm.service = '';

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

                vm.type = contact.type+"";

                vm.ruleForm.organization = contact.organization;
            },

            searchContacts()
            {
                    let vm = this;

                    let userId = vm.userId;

                    if(vm.searchForm.user != '')
                    {
                        userId = vm.searchForm.user;
                    }

                    let startDate = '';

                    let endDate = '';

                    if(vm.searchForm.startDate != '')
                    {
                        startDate = moment(vm.searchForm.startDate).format("YYYY-MM-DD");
                    }

                    if(vm.searchForm.endDate != '')
                    {
                        endDate = moment(vm.searchForm.endDate).format("YYYY-MM-DD")
                    }

                    vm.tableLoading = true;

                    vm.$message({
                        type: 'info',
                        message: 'Searching...'
                    });

                    axios.post('/contacts/search', {
                        startDate: startDate,
                        endDate: endDate,
                        source: vm.searchForm.source,
                        status: vm.searchForm.status,
                        userId: userId,
                    })
                        .then(function (response) {

                            vm.tableLoading = false;

                            if (response.data.success) {
                                vm.$message({
                                    type: 'success',
                                    message: response.data.message
                                });

                                vm.tableData = response.data.contacts.data;
                                vm.total = response.data.contacts.last_page;
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

            filterTag(value, row)
            {
                return row.tag === value;
            },

            details(user)
            {
                window.location.href = '/contact/details/' + user.id;
            },

            customLabel (option)
            {
                return `${option.label}`
            },

            userLabel (option)
            {
                return `${option.label}`
            },

            showReassignContactsDialog()
            {
                let vm = this;

                vm.reassignContactsDialogVisible = true;
            },

            exportContacts()
            {
                let vm = this;

                vm.$message({
                    type: 'info',
                    message: 'Generating excel...'
                });

                axios.post('/contacts/export', {
                    startDate: moment(vm.searchForm.startDate).format("YYYY-MM-DD"),
                    endDate: moment(vm.searchForm.endDate).format("YYYY-MM-DD"),
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
                            contacts: vm.selectedUsersForReassign.length,
                            contactsToBeReassigned: vm.selectedUsersForReassign
                        })
                            .then(function (response) {

                                if (response.data.success) {
                                    vm.$message({
                                        type: 'success',
                                        message: response.data.message
                                    });

                                    vm.selectedUsersForReassign = [];

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
            },

            handleSelectionChange(val) {
                this.selectedUsersForReassign = val;
            },

            handleCurrentChange(val) {
                let vm = this;

                vm.getUserContacts(val);
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

    .contact-type-container
    {
        margin-bottom: 18px;
        background-color: gainsboro;
        border-top: 2px solid #80808057;
    }
    .contact-type-span{
        margin-top: 10px;
    }

    @media(min-width:768px) and (max-width:991px){
        .el-dialog--small {
            width: 90%;
        }
    }

    @media(max-width:767px){
        .el-dialog--small {
            width: 90%;
        }
    }

    @media(min-width:992px) and (max-width:1199px){
        .el-dialog--small {
            width: 70%;
        }
    }
</style>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>