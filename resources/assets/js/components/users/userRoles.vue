<template>
    <div class="panel panel-default">
        <div class="col-lg-12 panel-header">
            <div class="col-lg-6">
                <h4>{{ username }}</h4>
            </div>
            <div class="col-lg-6" style="text-align: right">
                <button class="btn ebg-button" v-on:click="addUserRole()">Add Role</button>
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
                        prop="description"
                        label="Description">
                </el-table-column>

                <el-table-column
                        label="Actions">
                    <template slot-scope="scope">
                        <el-button @click="viewRole(scope.row)" size="small">View</el-button>
                        <el-button @click="revokePermissionFromUser(scope.row)" size="small">Revoke</el-button>
                    </template>
                </el-table-column>
            </el-table>
        </div>
        <hr class="panel-hr">
    </div>
</template>

<script>
    export default {
        props: ['userId'],
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
                username: '',
            }
        },
        created: function () {
            let vm = this;

            vm.getUserRoles();
        },
        methods: {
            getUserRoles: function () {
                let vm = this;

                axios.get('/api/get/user/roles/'+vm.userId)
                    .then(function (response) {
                        vm.username = response.data.username;
                        vm.tableData = [].concat(response.data.data);
                    }).catch(function (error) {
                    console.log(error);
                })
            },
            viewRole(role)
            {
                let vm = this;

                window.location.href = '/roles/details/'+role.id;
            },
            revokePermissionFromUser(role)
            {
                let vm = this;

                axios.get('/role/'+role.id+'/user/'+vm.userId+'/revoke')
                    .then(function (response) {
                        if (response.data.success)
                        {
                            vm.getUserRoles();

                            vm.$message({
                                type: 'success',
                                message: response.data.message
                            });
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
                })
            },
            addUserRole()
            {
                let vm = this;

                window.location.href = '/user/'+vm.userId+'/roles';
            }
        }
    }
</script>