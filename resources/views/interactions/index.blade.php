@extends('dashboard.default')


@section('main-content')

    <section class="content-header">
        <h1>
            Interactions List
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Interactions</li>
        </ol>
    </section>

    <section class="content">
        <interactions-table user-id="{!! $userId !!}" inline-template>
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <div class="pull-left">
                                <h3 class="box-title" style="padding-bottom: 25px">Interactions</h3>
                            </div>

                        </div>

                        <el-form :model="searchForm" :rules="searchRules" ref="searchForm" label-position="top"
                                 style="padding-left: 10px; padding-right: 10px">
                            <el-row :gutter="20">
                                <el-col :xs="24" :sm="24" :md="24" :lg="2">
                                    <el-form-item prop="filter" label="Filter By:">
                                    </el-form-item>
                                </el-col>
                                <el-col :xs="12" :sm="12" :md="6" :lg="4">
                                    <el-form-item prop="startDate" label="From date:">
                                        <el-date-picker
                                                v-model="searchForm.startDate"
                                                type="date"
                                                placeholder="Start Date">
                                        </el-date-picker>
                                    </el-form-item>
                                </el-col>

                                <el-col :xs="12" :sm="12" :md="6" :lg="4">
                                    <el-form-item prop="endDate" label="To date:">
                                        <el-date-picker
                                                v-model="searchForm.endDate"
                                                type="date"
                                                placeholder="End Date">
                                        </el-date-picker>
                                    </el-form-item>
                                </el-col>

                                <el-col :xs="6" :sm="6" :md="3" :lg="2" class="search-buttons">
                                    <el-button type="primary" icon="el-icon-search" @click="searchInteractions()">Search</el-button>
                                </el-col>

                                <el-col :xs="6" :sm="6" :md="3" :lg="2" class="search-buttons">
                                    @if(in_array(11, getPermissions()))
                                        <el-button type="primary" icon="el-icon-download" @click="exportInteractions()">Export</el-button>
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
                </div>
            </div>
        </interactions-table>
    </section>

@stop