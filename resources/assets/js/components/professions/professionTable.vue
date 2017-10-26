<template>
    <div class="panel panel-default">
        <div class="col-lg-12 panel-header">
            <div class="col-lg-6">
                <h4>Professions</h4>
            </div>
            <div class="col-lg-6" style="text-align: right">
                <button class="btn ebg-button" v-on:click="showAddProfessionDialog()">Add Profession</button>
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
                        <el-button @click="EditProfession(scope.row)" size="small">Edit</el-button>
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
                title="New/Edit Profession"
                :visible.sync="dialogVisible"
                size="tiny">
            <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-position="top">

                <el-form-item prop="professionName" label="Profession Name">
                    <el-input placeholder="Input Name" v-model="ruleForm.professionName"></el-input>
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
                <el-button type="primary" @click="addProfession('ruleForm')">Save</el-button>
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
                dialogVisible: false,
                professionId: null,
                ruleForm: {
                    professionName: '',
                    active: ''
                },
                rules: {
                    professionName : [
                        {required: true, message: 'Please input profession name', trigger: 'blur'},
                    ],
                    active : [
                        {required: true, message: 'Please active status', trigger: 'change'},
                    ],
                },
            }
        },
        created: function () {
            let vm = this;

            vm.getProfessions();
        },

        methods:{
            handleClick() {
                console.log('click');
            },
            getProfessions()
            {
                let vm = this;
                axios.get('/api/professions')
                    .then(function (response) {
                        vm.tableData = [].concat(response.data.data);
                        vm.total = response.data.last_page;
                    }).catch(function (error) {
                    console.log(error);
                })
            },
            showAddProfessionDialog()
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
            addProfession(formName)
            {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        let vm = this;
                        axios.post('/professions/save', {
                            name     : vm.ruleForm.professionName,
                            active : vm.ruleForm.active,
                            professionId: vm.professionId
                        })
                            .then(function (response)
                            {
                                vm.dialogVisible = false;

                                vm.getProfessions();

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
            EditProfession(profession)
            {
                let vm = this;

                vm.dialogVisible = true;

                vm.ruleForm.professionName = profession.name;

                vm.professionId = profession.id;
            },
            filterTag(value, row) {
                return row.tag === value;
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