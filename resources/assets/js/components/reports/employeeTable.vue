<template>
</template>

<script>
    import Multiselect from 'vue-multiselect';

    import moment from 'moment';

    export default {
        props: ['reportId'],
        data() {
            return {
                tableData: [],
                total: 0,
                loading: false,
                dialogVisible: false,
            }
        },
        created: function () {
            let vm = this;

            vm.getUsers();
        },

        methods:{
            handleClick() {
                console.log('click');
            },
            getUsers(page = null)
            {
                let vm = this;

                vm.loading = true;

                let url = '/api/users';

                if (page != null)
                {
                    url = '/api/users/?page='+page
                }

                axios.get(url)
                    .then(function (response) {
                        vm.tableData = response.data.data;
                        vm.total = response.data.last_page * 10;
                        vm.loading = false;
                    }).catch(function (error) {
                    console.log(error);
                })
            },
            handleCurrentChange(val)
            {
                let vm = this;

                vm.getUsers(val);
            },

            viewUserReport(user)
            {
                window.location.href = '/report/'+this.reportId+'/user/'+user.id;
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