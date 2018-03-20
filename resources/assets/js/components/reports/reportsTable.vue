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
            }
        },
        created: function () {
            let vm = this;

            vm.getReports();
        },

        methods:{
            handleClick() {
                console.log('click');
            },

            getReports(page = null)
            {
                let vm = this;

                vm.loading = true;

                let url = '/api/reports/';

                if (page != null)
                {
                    url = '/api/reports/?page='+page
                }

                axios.get(url)
                    .then(function (response) {
                        vm.tableData = response.data.reports.data;
                        vm.total = response.data.reports.last_page * 10;
                        vm.loading = false;
                    }).catch(function (error) {
                    console.log(error);
                })
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
</style>