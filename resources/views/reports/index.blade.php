@extends('dashboard.default')


@section('main-content')

    <section class="content-header">
        <h1>
           Reports List
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Reports</li>
        </ol>
    </section>

    <section class="content">
        <reports-table user-id="{!! \Illuminate\Support\Facades\Auth::id() !!}" inline-template>
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <div class="pull-left">
                                <h3 class="box-title" style="padding-bottom: 25px">Reports</h3>
                            </div>
                        </div>

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
                                    prop=""
                                    label="Actions">
                                <template slot-scope="scope">
                                    <el-button @click="viewReport(scope.row)" size="small">View</el-button>
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
        </reports-table >
    </section>
@stop