@extends('dashboard.default')


@section('dashboard-content')

    <div class="row">
        <div class="col-lg-12">
            <interactions-table user-id="{!! $userId !!}" inline-template>
                <div class="panel panel-default contact-panel">
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
                            <el-row :gutter="20">
                                <el-col :span="2">
                                    <el-form-item prop="filter" label="Filter By:">
                                    </el-form-item>
                                </el-col>
                                <el-col :span="7">
                                    <el-form-item prop="startDate" label="From date:">
                                        <el-date-picker
                                                v-model="searchForm.startDate"
                                                type="date"
                                                placeholder="Start Date">
                                        </el-date-picker>
                                    </el-form-item>
                                </el-col>

                                <el-col :span="7">
                                    <el-form-item prop="endDate" label="To date:">
                                        <el-date-picker
                                                v-model="searchForm.endDate"
                                                type="date"
                                                placeholder="End Date">
                                        </el-date-picker>
                                    </el-form-item>
                                </el-col>

                                <el-col :span="3" style="margin-top: 30px">
                                    <el-button type="primary" @click="searchInteractions()">Search</el-button>
                                </el-col>

                                <el-col :span="3" style="margin-top: 30px">
                                    @if(in_array(11, getPermissions()))
                                        <el-button type="primary" @click="exportInteractions()">Export</el-button>
                                    @endif
                                </el-col>
                            </el-row>


                        </el-form>

                        <div class="col-lg-12">
                            <hr>
                        </div>

                        <el-table
                                :data="tableData"
                                v-loading.body="loading"
                                stripe
                                style="width: 100%">
                            <el-table-column
                                    label="Name">
                                <template slot-scope="scope">
                                    <el-row>
                                        <el-col :span="24">
                                            <span>@{{ scope.row.remarks }}</span>
                                        </el-col>
                                        <el-col :span="24" :gutter="10" style="margin-top:10px">
                                            <el-col :span="16">
                                                <span>Date: @{{ scope.row.date }}</span>
                                            </el-col>
                                            <el-col :span="8">
                                                <span>Interacted over a @{{ scope.row.interactionType }}</span>
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
                                    @current-change="handleCurrentChange"
                                    :total="total">
                            </el-pagination>
                        </div>
                    </div>
                </div>
            </interactions-table>
        </div>
    </div>

@stop