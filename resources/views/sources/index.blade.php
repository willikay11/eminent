@extends('dashboard.default')


@section('dashboard-content')

    <div class="row">
        <div class="col-lg-12">
            <sources-table inline-template>
                <div class="panel panel-default">
                    <div class="col-lg-12 panel-header">
                        <div class="col-lg-6">
                            <h4>Sources</h4>
                        </div>
                        <div class="col-lg-6" style="text-align: right">
                            @if(in_array(17, getPermissions()))
                                <button class="btn ebg-button" v-on:click="showAddSourcesDialog()">Add Source</button>
                            @endif
                        </div>
                    </div>
                    <div class="panel-body">
                        <el-table
                                :data="tableData"
                                stripe
                                style="width: 100%">
                            <el-table-column
                                    prop="name"
                                    label="Name">
                            </el-table-column>
                            <el-table-column
                                    prop="tag"
                                    label="Active">
                                <template slot-scope="scope">
                                    <el-tag
                                            :type="scope.row.active === 'Active' ? 'success' : 'danger'"
                                            close-transition>@{{scope.row.active}}</el-tag>
                                </template>
                            </el-table-column>
                            @if(in_array(17, getPermissions()))
                                <el-table-column
                                        label="Actions"
                                        width="120">
                                    <template slot-scope="scope">
                                        <el-button @click="EditSource(scope.row)" size="small">Edit</el-button>
                                    </template>
                                </el-table-column>
                            @endif
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

                    <el-dialog
                            title="New/Edit Source"
                            :visible.sync="dialogVisible"
                            size="tiny">
                        <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-position="top">

                            <el-form-item prop="sourceName" label="Source Name">
                                <el-input placeholder="Input Name" v-model="ruleForm.sourceName"></el-input>
                            </el-form-item>

                            <el-form-item prop="active" label="Active">
                                <el-select v-model="ruleForm.active" placeholder="Select">
                                    <el-option
                                            v-for="item in options"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-form>
                        <span slot="footer" class="dialog-footer">
                <el-button @click="dialogVisible = false">Cancel</el-button>
                            <el-button type="primary" @click="addSource('ruleForm')">Save</el-button>
            </span>
                    </el-dialog>
                </div>
            </sources-table>
        </div>
    </div>
@stop