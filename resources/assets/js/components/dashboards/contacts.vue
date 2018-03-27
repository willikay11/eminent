<template>
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
</template>

<script>
    export default {
        props: ['userId'],
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

        methods: {
            handleClick() {
                console.log('click');
            },
            getUsers()
            {
                let vm = this;
                axios.get('/api/dashboard/contacts/user/' + vm.userId)
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
    .el-table {
        border-left: none;
        border-right: none;
    }
</style>