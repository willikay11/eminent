<template>
    <div class="panel panel-default">
        <div class="col-lg-12 panel-header">
            <div class="col-lg-6">
                <h4>Roles</h4>
            </div>
            <div class="col-lg-6" style="text-align: right">
                <button class="btn ebg-button" v-on:click="showAddRoleDialog()">Add Role</button>
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
                        label="Actions"
                        width="120">
                    <template slot-scope="scope">
                        <el-button @click="handleClick" size="small">Details</el-button>
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

        <el-dialog
                title="Tips"
                :visible.sync="dialogVisible"
                size="tiny">
            <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-position="top">

                <el-form-item prop="roleName" label="Role Name">
                    <el-input placeholder="Input Name" v-model="ruleForm.roleName"></el-input>
                </el-form-item>

                <el-form-item prop="roleDescription" label="Description">
                    <el-input placeholder="Input Description" v-model="ruleForm.roleDescription"></el-input>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button @click="dialogVisible = false">Cancel</el-button>
                <el-button type="primary" @click="addRole('ruleForm')">Save</el-button>
            </span>
        </el-dialog>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                tableData: [],
                total: 0,
                dialogVisible: false,
                ruleForm: {
                    roleName: '',
                    roleDescription: '',
                },
                rules: {
                    roleName : [
                        {required: true, message: 'Please input role name', trigger: 'blur'},
                    ],
                    roleDescription: [
                        {required: true, message: 'Please input description', trigger: 'blur'},
                    ],
                },
            }
        },
        created: function () {
            let vm = this;

            vm.getPermissions();
        },

        methods:{
            handleClick() {
                console.log('click');
            },
            getPermissions()
            {
                let vm = this;
                axios.get('/api/roles')
                    .then(function (response) {
                        vm.tableData = [].concat(response.data.data);
                        vm.total = response.data.last_page;
                    }).catch(function (error) {
                    console.log(error);
                })
            },
            showAddRoleDialog()
            {
                let vm = this;

                vm.dialogVisible = true;
            },
            handleClose(done) {
                this.$confirm('Are you sure to close this dialog?')
                    .then(_ => {
                        done();
                    })
                    .catch(_ => {});
            },
            addRole(formName)
            {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        let vm = this;
                        axios.post('/roles/save', {
                            name     : vm.ruleForm.roleName,
                            description : vm.ruleForm.roleDescription,
                            active : 1,
                        })
                            .then(function (response)
                            {
                                vm.dialogVisible = false;

                                vm.getPermissions();

                                if(response.data.success)
                                {
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
                        });
                    } else {
                        return false;
                    }
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
</style>