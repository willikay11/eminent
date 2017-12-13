<template>
    <div class="panel panel-default">
        <div class="col-lg-12 panel-header">
            <div class="col-lg-6">
                <h4>Role Details</h4>
            </div>
            <div class="col-lg-6" style="text-align: right">
            </div>
        </div>
        <div class="panel-body">
            <div class="row" style="padding-left: 20px">
                <h5>{{ name }}</h5>
                <h6>{{ description }}</h6>
            </div>

            <hr>

            <h4>Members</h4>
            <el-table
                    :data="memberTableData"
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
                        <el-button @click="revokeUser(scope.row)" size="small">Revoke</el-button>
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

        <div class="panel-body">
            <div class="col-lg-12 panel-header">
                <div class="col-lg-6">
                    <h4>Role Permissions</h4>
                </div>
                <div class="col-lg-6" style="text-align: right">
                    <button class="btn ebg-button" v-on:click="showAddRolePermission()">Add Role Permission</button>
                </div>
            </div>
            <el-table
                    :data="permissionsTableData"
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
                        label="Actions"
                        width="120">
                    <template slot-scope="scope">
                        <el-button @click="revokePermission(scope.row)" size="small">Revoke</el-button>
                    </template>
                </el-table-column>
            </el-table>
        </div>
        <hr class="panel-hr">
        <div class="panel-footer">
            <div class="block">
                <el-pagination
                        layout="prev, pager, next"
                        :total="totalPermissions">
                </el-pagination>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['id', 'name', 'description'],
        data() {
            return {
                memberTableData: [],
                permissionsTableData: [],
                totalPermissions: 0,
                total: 0,
            }
        },
        created: function () {
            let vm = this;

            vm.getRoleMembers();

            vm.getRolePermissions();
        },

        methods:{
            handleClick() {
                console.log('click');
            },
            getRoleMembers()
            {
                let vm = this;
                axios.get('/api/role/'+ vm.id +'/members')
                    .then(function (response) {
                        vm.memberTableData = response.data;
//                        vm.total = response.data.last_page;
                    }).catch(function (error) {
                    console.log(error);
                })
            },
            getRolePermissions()
            {
                let vm = this;
                axios.get('/api/role/'+ vm.id +'/permissions')
                    .then(function (response) {
                        vm.permissionsTableData = [].concat(response.data.data);
                        vm.totalPermissions = response.data.last_page;
                    }).catch(function (error) {
                    console.log(error);
                })
            },
            showAddRolePermission()
            {
                let vm = this;

                window.location.href = '/roles/permissions/' + vm.id;
            },
            revokeUser(row)
            {
                let vm = this;

                vm.$message({
                    type: 'info',
                    message: 'Revoking role from user'
                });

                axios.get('/roles/revoke/'+row.id)
                    .then(function (response) {

                        if (response.data.success)
                        {
                            vm.$message({
                                type: 'success',
                                message: 'Role revoked from user'
                            });

                            vm.getRoleMembers();
                        }
                        else
                        {
                            vm.$message({
                                type: 'error',
                                message: response.data.message
                            });

                            vm.getRoleMembers();
                        }
                    }).catch(function (error) {
                    console.log(error);
                })
            },
            revokePermission(row)
            {
                let vm = this;

                vm.$message({
                    type: 'info',
                    message: 'Revoking permission from role'
                });

                axios.get('/permission/revoke/role/'+ vm.id +'/'+row.id)
                    .then(function (response) {

                        if (response.data.success)
                        {
                            vm.$message({
                                type: 'success',
                                message: 'Permission revoked from role'
                            });

                            vm.getRolePermissions();
                        }
                        else
                        {
                            vm.$message({
                                type: 'error',
                                message: response.data.message
                            });

                            vm.getRolePermissions();
                        }
                    }).catch(function (error) {
                    console.log(error);
                })
            }
        }
    }
</script>