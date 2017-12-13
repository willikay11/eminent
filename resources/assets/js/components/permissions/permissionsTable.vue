<template>
    <div class="panel panel-default">
        <div class="col-lg-12 panel-header">
            <div class="col-lg-6">
                <h4>Permissions</h4>
            </div>
            <div class="col-lg-6">
            </div>
        </div>
        <div class="panel-body">
            <el-table
                    :data="tableData"
                    v-loading.body="loading"
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
                        <el-button @click="handleClick" size="small">Detail</el-button>
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
    </div>
</template>

<script>
    export default {
        data() {
            return {
                tableData: [],
                total: 0,
                loading: true
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
            getPermissions(page = null)
            {
                let vm = this;

                vm.loading = true;

                let url = '/api/permissions';

                if (page != null)
                {
                    url = '/api/permissions/?page='+page
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
            handleCurrentChange(val) {
                let vm = this;

                vm.getPermissions(val);
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