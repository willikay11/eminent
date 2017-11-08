<template>
    <div class="panel panel-default">
        <div class="col-lg-12 panel-header">
            <div class="col-lg-6">
                <h4>Interactions</h4>
            </div>
            <div class="col-lg-6" style="text-align: right">

            </div>

            <div class="col-lg-12">
                <hr>
            </div>

        </div>

        <div class="panel-body">

            <el-form :model="searchForm" :rules="searchRules" ref="searchForm" label-position="top"
                     style="padding-left: 30px">
                <el-col :span="2">
                    <el-form-item prop="filter" label="Filter By:">
                    </el-form-item>
                </el-col>
                <el-col :span="5">
                    <el-form-item prop="startDate" label="From date:">
                        <el-date-picker
                                v-model="searchForm.startDate"
                                type="date"
                                placeholder="Start Date">
                        </el-date-picker>
                    </el-form-item>
                </el-col>

                <el-col :span="5">
                    <el-form-item prop="endDate" label="To date:">
                        <el-date-picker
                                v-model="searchForm.endDate"
                                type="date"
                                placeholder="End Date">
                        </el-date-picker>
                    </el-form-item>
                </el-col>

                <el-col :span="5">
                    <el-form-item prop="source" label="Status:">
                        <el-select v-model="searchForm.status" placeholder="Select status">
                            <el-option
                                    v-for="item in sources"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-col>

            </el-form>

            <div class="col-lg-12">
                <hr>
            </div>

            <el-table
                    :data="tableData"
                    stripe
                    style="width: 100%">
                <el-table-column
                        label="Name">
                    <template slot-scope="scope">
                        <el-row>
                            <el-col :span="24">
                                <span>{{ scope.row.remarks }}</span>
                            </el-col>
                            <el-col :span="24" :gutter="10" style="margin-top:10px">
                                <el-col :span="8">
                                    <span>Date: {{ scope.row.date }}</span>
                                </el-col>
                                <el-col :span="8">
                                    <span>Interacted over a {{ scope.row.interactionType }}</span>
                                </el-col>
                            </el-col>
                        </el-row>
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
    </div>
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
                    status: '',
                },
                searchRules: {
                    startDate: [
                        {required: true, message: 'Please input start date', trigger: 'blur', type: 'date'},
                    ],
                    endDate: [
                        {required: true, message: 'Please input end date', trigger: 'blur', type: 'date'},
                    ],
                    status: [
                        {required: true, message: 'Please select status', trigger: 'change'},
                    ],
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
                        vm.tableData = [].concat(response.data.data);
                        vm.total = response.data.last_page;
                    }).catch(function (error) {
                    console.log(error);
                })
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