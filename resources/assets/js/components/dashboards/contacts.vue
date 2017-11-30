<template>
    <div class="panel panel-default" style="margin-right: 0px">
        <div class="col-lg-12 panel-header">
            <div class="col-lg-6">
                <h4>Contacts</h4>
            </div>
            <div class="col-lg-6" style="text-align: right">

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
                        label="Actions"
                        width="120">
                    <template slot-scope="scope">
                        <el-button @click="showDetails(scope.row)" size="small">Details</el-button>
                    </template>
                </el-table-column>
            </el-table>
        </div>
        <hr class="panel-hr">
        <div class="panel-footer">
            <button class="btn ebg-button" v-on:click="showMore()">See More</button>
        </div>
    </div>
</template>

<script>
    export default {
        props:['userId'],
        data() {
            return {
                tableData: [],
                total: 0,
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
            getUsers()
            {
                let vm = this;
                axios.get('/api/dashboard/contacts/user/'+vm.userId)
                    .then(function (response) {
                        vm.tableData = response.data.contacts.data;
                    }).catch(function (error) {
                    console.log(error);
                })
            },
            showMore()
            {
                window.location.href = '/contacts/user';
            },
            showDetails(user)
            {
                window.location.href = '/contact/details/' + user.id;
            }
        }
    }
</script>

<style>
    .el-table{
        border-left: none;
        border-right: none;
    }
</style>