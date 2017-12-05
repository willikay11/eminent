<template>
</template>

<script>
    export default {
        props: ['userId'],
        data() {
            return {
                tableData: [],
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
            getInteractions()
            {
                let vm = this;
                axios.get('/api/interactions/'+vm.userId)
                    .then(function (response) {
                        vm.tableData = response.data.interactions.data;
                        vm.total = response.data.interactions.last_page;
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
</style>