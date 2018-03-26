<template>
    <div v-loading="loading">
        <el-row :xs="24" :sm="24" :md="24" :lg="24" :gutter="20">
            <el-form label-position="top"
                     style="padding-left: 30px">

                <el-col :xs="24" :sm="24" :md="24" :lg="2">
                    <el-form-item prop="filter" label="Filter By:">
                    </el-form-item>
                </el-col>

                <el-col :xs="12" :sm="12" :md="6" :lg="8">
                    <el-form-item prop="startDate" label="From date:">
                        <el-date-picker
                                v-model="startDate"
                                type="date"
                                placeholder="Start Date">
                        </el-date-picker>
                    </el-form-item>
                </el-col>

                <el-col :xs="12" :sm="12" :md="6" :lg="8">
                    <el-form-item prop="endDate" label="To date:">
                        <el-date-picker
                                v-model="endDate"
                                type="date"
                                placeholder="End Date">
                        </el-date-picker>
                    </el-form-item>
                </el-col>


                <el-col :xs="6" :sm="6" :md="3" :lg="2">
                    <el-form-item prop="search" style="margin-top: 56px">
                        <el-button type="primary" @click="getUserData()">Filter</el-button>
                    </el-form-item>
                </el-col>

            </el-form>
        </el-row>

        <chartjs-line :labels="labels" :datasets="mydatasets" :bind="true"></chartjs-line>
    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        props: ['reportId', 'userId'],
        data() {
            return {
                    labels: [],
                    mydatasets:[{
                        label: "",
                        fill: false,
                        lineTension: 0.2,
                        backgroundColor: "rgba(255, 189, 209, 1)",
                        borderColor: "rgba(228, 62, 82, 1)",
                        borderCapStyle: 'butt',
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJoinStyle: 'miter',
                        pointBorderColor: "rgba(75,192,192,1)",
                        pointBackgroundColor: "#fff",
                        pointBorderWidth: 1,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "rgba(228, 62, 82, 1)",
                        pointHoverBorderColor: "rgba(255, 189, 209, 1)",
                        pointHoverBorderWidth: 2,
                        pointRadius: 1,
                        pointHitRadius: 10,
                        data: [],
                        spanGaps: false,
                    },
                        {
                            label: "",
                            fill: false,
                            lineTension: 0.1,
                            backgroundColor: "rgba(255, 255, 137, 1)",
                            borderColor: "rgba(245, 166, 35, 1)",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "rgba(75,192,192,1)",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 1,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(245, 166, 35, 1)",
                            pointHoverBorderColor: "rgba(255, 255, 137, 1)",
                            pointHoverBorderWidth: 2,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: [],
                            spanGaps: false,
                        },
                        {
                            label: "",
                            fill: false,
                            lineTension: 0.1,
                            backgroundColor: "rgba(125, 194, 255, 1)",
                            borderColor: "rgba(74, 143, 227, 1)",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "rgba(75,192,192,1)",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 1,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(74, 143, 227, 1)",
                            pointHoverBorderColor: "rgba(125, 194, 255, 1)",
                            pointHoverBorderWidth: 2,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: [],
                            spanGaps: false,
                        },
                        {
                            label: "",
                            fill: false,
                            lineTension: 0.1,
                            backgroundColor: "rgba(95, 213, 152, 1)",
                            borderColor: "rgba(18, 136, 75, 1)",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "rgba(75,192,192,1)",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 1,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(18, 136, 75, 1)",
                            pointHoverBorderColor: "rgba(95, 213, 152, 1)",
                            pointHoverBorderWidth: 2,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: [],
                            spanGaps: false,
                        }
                    ],
                loading: false,
                startDate: moment().subtract(7, 'days').calendar(),
                endDate: moment(),
            }
        },
        created: function () {
            let vm = this;

            vm.getUserData();
        },

        methods:{
            handleClick() {
                console.log('click');
            },

            getUserData()
            {
                let vm = this;

                vm.loading = true;

                let url = '/api/activity/report';

                axios.post(url, {
                    start_date: vm.startDate,
                    end_date: vm.endDate,
                    user_id: vm.userId
                })
                    .then(function (response) {
                        vm.labels = response.data.activities.labels;
                        vm.mydatasets[0].data = response.data.activities.todo;
                        vm.mydatasets[0].label = response.data.activities.todoLabel;
                        vm.mydatasets[1].data = response.data.activities.ongoing;
                        vm.mydatasets[1].label = response.data.activities.ongoingLabel;
                        vm.mydatasets[2].data = response.data.activities.review;
                        vm.mydatasets[2].label = response.data.activities.reviewLabel;
                        vm.mydatasets[3].data = response.data.activities.completed;
                        vm.mydatasets[3].label = response.data.activities.completedLabel;
                        vm.loading = false;
                    }).catch(function (error) {
                    console.log(error);
                })
            },
            handleCurrentChange(val)
            {
                let vm = this;

                vm.getUsers(val);
            },

            filterReport()
            {

            },
            viewUserReport(user)
            {
                window.location.href = '/report/'+this.reportId+'/user/'+user.id;
            }
        }
    }
</script>

<style>
    .el-date-editor.el-input, .el-date-editor.el-input__inner
    {
        width: 100%;
    }
</style>