<template>
    <div class="panel panel-default" style="margin-left: 0px">
        <div class="col-lg-12 panel-header">
            <div class="col-lg-6">
                <h4>Interactions</h4>
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
            <button class="btn ebg-button" v-on:click="showMore()">See More</button>
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
                    }).catch(function (error) {
                    console.log(error);
                })
            },
            showMore()
            {
                window.location.href = '/interactions/user';
            },
        }
    }
</script>

<style>
    .el-table{
        border-left: none;
        border-right: none;
    }
</style>