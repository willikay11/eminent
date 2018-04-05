@extends('dashboard.default')


@section('main-content')

    <section class="content-header">
        <h1>
            All Contacts List
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">All Contacts</li>
        </ol>
    </section>

    <section class="content">
        <all-contacts-table inline-template>
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <div class="pull-left">
                                <h3 class="box-title" style="padding-bottom: 25px">All Contacts</h3>
                            </div>
                        </div>

                        <el-table
                                :data="tableData"
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
                                    prop="source"
                                    label="Source">
                            </el-table-column>
                            <el-table-column
                                    prop="tag"
                                    label="Status">
                                <template slot-scope="scope">
                                    <el-tag
                                            :type="scope.row.clientExists === 1 ? 'success' : 'warning'"
                                            close-transition>@{{scope.row.status}}
                                    </el-tag>
                                </template>
                            </el-table-column>
                            <el-table-column
                                    label="Actions">
                                <template slot-scope="scope">
                                    <el-button @click="details(scope.row)" size="small">Details</el-button>
                                </template>
                            </el-table-column>
                        </el-table>

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
                </div>
            </div>
        </all-contacts-table>
    </section>
@stop