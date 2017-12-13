<template>
    <div class="panel panel-default">
        <div class="col-lg-12 panel-header">
            <div class="col-lg-6">
                <h4>Designations</h4>
            </div>
            <div class="col-lg-6" style="text-align: right">
                <button class="btn ebg-button" v-on:click="showAddRoleDialog()">Add Designations</button>
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
                        prop="tag"
                        label="Active">
                    <template slot-scope="scope">
                        <el-tag
                                :type="scope.row.active === 'Active' ? 'success' : 'danger'"
                                close-transition>{{scope.row.active}}</el-tag>
                    </template>
                </el-table-column>
                <el-table-column
                        label="Actions"
                        width="120">
                    <template slot-scope="scope">
                        <el-button @click="EditDesignation(scope.row)" size="small">Edit</el-button>
                    </template>
                </el-table-column>
            </el-table>
        </div>
        <hr class="panel-hr">
        <div class="panel-footer">
            <div class="block">
                <el-pagination
                        layout="prev, pager, next"
                        @current-change="handleCurrentChange"
                        :total="total">
                </el-pagination>
            </div>
        </div>

        <el-dialog
                title="New/Edit Designation"
                :visible.sync="dialogVisible"
                size="tiny">
            <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-position="top">

                <el-form-item prop="designationName" label="Designation Name">
                    <el-input placeholder="Input Name" v-model="ruleForm.designationName"></el-input>
                </el-form-item>

                <el-form-item prop="active" label="Active">
                    <el-select v-model="ruleForm.active" placeholder="Select">
                        <el-option
                                v-for="item in options"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                        </el-option>
                    </el-select>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button @click="dialogVisible = false">Cancel</el-button>
                <el-button type="primary" @click="addDesignation('ruleForm')">Save</el-button>
            </span>
        </el-dialog>
    </div>
</template>

<script>
    export default {
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
                total: 0,
                loading: true,
                dialogVisible: false,
                designationId: null,
                ruleForm: {
                    designationName: '',
                    active: ''
                },
                rules: {
                    designationName : [
                        {required: true, message: 'Please input designation name', trigger: 'blur'},
                    ],
                    active : [
                        {required: true, message: 'Please active status', trigger: 'change'},
                    ]
                },
            }
        },
        created: function () {
            let vm = this;

            vm.getDesignations();
        },

        methods:{
            handleClick() {
                console.log('click');
            },
            getDesignations(page = null)
            {
                let vm = this;

                vm.loading = true;

                let url = '/api/designations';

                if (page != null)
                {
                    url = '/api/designations/?page='+page
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
            addDesignation(formName)
            {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        let vm = this;
                        axios.post('/designations/save', {
                            name     : vm.ruleForm.designationName,
                            active : vm.ruleForm.active,
                            designationId: vm.designationId
                        })
                            .then(function (response)
                            {
                                vm.dialogVisible = false;

                                vm.getDesignations();

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
            },

            EditDesignation(designation)
            {
                let vm = this;

                vm.dialogVisible = true;

                vm.ruleForm.designationName = designation.name;

                vm.designationId = designation.id;
            },

            filterTag(value, row) {
                return row.tag === value;
            },

            handleCurrentChange(val) {
                let vm = this;

                vm.getDesignations(val);
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