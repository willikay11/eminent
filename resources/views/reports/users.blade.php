@extends('dashboard.default')


@section('main-content')

    <section class="content-header">
        <h1>
            Users List
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Users</li>
        </ol>
    </section>

    <section class="content">
        <employee-table report-id="{!! $id !!}" inline-template>
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <div class="pull-left">
                                <h3 class="box-title" style="padding-bottom: 25px">Users</h3>
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
                                    prop="email"
                                    label="Email">
                            </el-table-column>
                            <el-table-column
                                    prop="phone"
                                    label="Phone Number">
                            </el-table-column>
                            <el-table-column
                                    prop="tag"
                                    label="Active"
                                    width="100">
                                <template slot-scope="scope">
                                    <el-tag
                                            :type="scope.row.active === 'Active' ? 'success' : 'danger'"
                                            close-transition>@{{scope.row.active}}</el-tag>
                                </template>
                            </el-table-column>
                            @if(in_array(1, getPermissions()))
                                <el-table-column
                                        label="Actions">
                                    <template slot-scope="scope">
                                        <el-button @click="viewUserReport(scope.row)" size="small">View</el-button>
                                    </template>
                                </el-table-column>
                            @endif
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
        </employee-table>
    </section>
@stop