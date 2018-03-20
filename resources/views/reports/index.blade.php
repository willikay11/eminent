@extends('dashboard.default')


@section('dashboard-content')

    <div class="row">
        <div class="col-lg-12">
            <reports-table user-id="{!! \Illuminate\Support\Facades\Auth::id() !!}" inline-template>
                <div class="panel panel-default contact-panel">
                    <div class="col-lg-12 panel-header">
                        <div class="col-lg-6">
                            <h4>Reports</h4>
                        </div>
                        <div class="col-lg-6" style="text-align: right">

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
                                    prop=""
                                    label="Actions">
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
            </reports-table>
        </div>
    </div>

@stop