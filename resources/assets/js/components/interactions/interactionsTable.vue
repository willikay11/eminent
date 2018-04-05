<template>
</template>

<script>
    import moment from 'moment';

    export default {
        props: ['userId'],
        data() {
            return {
                tableData: [],
                loading: true,
                total: 0,
                searchForm: {
                    startDate: '',
                    endDate: '',
                },
                searchRules: {
                    startDate: [
                        {required: true, message: 'Please input start date', trigger: 'blur', type: 'date'},
                    ],
                    endDate: [
                        {required: true, message: 'Please input end date', trigger: 'blur', type: 'date'},
                    ]
                },
            }
        },
        created: function () {
            let vm = this;

            vm.getInteractions();
        },

        methods:{
            handleClick() {
                console.log('click');
            },

            getInteractions(page = null)
            {
                let vm = this;

                vm.loading = true;

                let url = '/api/interactions/'+vm.userId;

                if (page != null)
                {
                    url = '/api/interactions/'+vm.userId+'?page='+page
                }

                axios.get(url)
                    .then(function (response) {
                        vm.tableData = response.data.interactions.data;
                        vm.total = response.data.interactions.last_page * 10;
                        vm.loading = false;
                    }).catch(function (error) {
                    console.log(error);
                })
            },
            searchInteractions()
            {
                let vm = this;

                vm.$message({
                    type: 'info',
                    message: 'Searching...'
                });

                axios.post('/interactions/search', {
                    startDate: moment(vm.searchForm.startDate).format("YYYY-MM-DD"),
                    endDate: moment(vm.searchForm.endDate).format("YYYY-MM-DD"),
                    userId: vm.userId,
                })
                    .then(function (response) {

                        if (response.data.success) {
                            vm.$message({
                                type: 'success',
                                message: response.data.message
                            });

                            vm.tableData = response.data.interactions.data;
                            vm.total = response.data.interactions.last_page;
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

            exportInteractions()
            {
                let vm = this;

                vm.$message({
                    type: 'info',
                    message: 'Generating Excel...'
                });

                axios.post('/interactions/export', {
                    startDate: vm.searchForm.startDate+"",
                    endDate: vm.searchForm.endDate+"",
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
            handleCurrentChange(val) {
                let vm = this;

                vm.getInteractions(val);
            }
        }
    }
</script>

<style>
    .el-table{
        border-left: none;
        border-right: none;
    }
    .el-date-editor.el-input {
        width: 100%;
    }

    @media only screen and (min-width : 768px) {
        .search-buttons{
            margin-top: 20px;
            margin-right: 30px;
        }
    }

    /* Medium Devices, Desktops */
    @media only screen and (min-width : 992px) {
        .search-buttons{
            margin-top: 55px;
            margin-right: 30px;
        }
    }

    /* Large Devices, Wide Screens */
    @media only screen and (min-width : 1200px) {
        .search-buttons{
            margin-top: 55px;
            margin-right: 30px;
        }
    }
</style>