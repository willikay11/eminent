@extends('dashboard.default')


@section('dashboard-content')

    <div class="row">
        <div class="col-lg-12">
            <individual-activity activity-id="{!! $activityId !!}" inline-template>
                <div>
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" style="background-color: white">
                        <el-tabs v-model="activeName" style="min-height: 500px; padding-bottom: 20px">
                            <el-tab-pane label="Overview" name="first">
                                <div class="row">
                                    <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-position="left">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <el-col :xs="24" :sm="24" :md="24" :lg="4">
                                                <span>Activity: </span>
                                            </el-col>
                                            <el-col :xs="22" :sm="22" :md="22" :lg="20">
                                                <el-form-item prop="name">
                                                    <el-input placeholder="Activity Name" v-model="ruleForm.name"></el-input>
                                                </el-form-item>
                                            </el-col>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <el-col :xs="24" :sm="24" :md="24" :lg="4">
                                                <span>Description: </span>
                                            </el-col>
                                            <el-col :xs="22" :sm="22" :md="22" :lg="20">
                                                <el-form-item prop="description">
                                                    <el-input placeholder="Activity Description"
                                                              type="textarea"
                                                              :rows="3"
                                                              v-model="ruleForm.description"></el-input>
                                                </el-form-item>
                                            </el-col>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <el-col :xs="24" :sm="24" :md="24" :lg="4">
                                                <span>Activity Type: </span>
                                            </el-col>

                                            <el-col :xs="22" :sm="22" :md="22" :lg="20">
                                                <el-form-item prop="activityType">
                                                    <el-select v-model="ruleForm.activityType" placeholder="Select Activity Type">
                                                        <el-option
                                                                v-for="item in activityTypes"
                                                                :key="item.value"
                                                                :label="item.label"
                                                                :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </el-form-item>
                                            </el-col>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <el-row :span="24" :gutter="20" v-if="ruleForm.activityType == 2">
                                                <el-col :xs="24" :sm="24" :md="24" :lg="4">
                                                    <span>Source: </span>
                                                </el-col>
                                                <el-col :xs="22" :sm="22" :md="22" :lg="20">
                                                    <el-form-item prop="source">
                                                        <el-select v-model="ruleForm.source" filterable placeholder="Select Source">
                                                            <el-option
                                                                    v-for="item in userClients"
                                                                    :key="item.value"
                                                                    :label="item.label"
                                                                    :value="item.value">
                                                            </el-option>
                                                        </el-select>
                                                    </el-form-item>
                                                </el-col>
                                            </el-row>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <el-row :span="24" :gutter="20" v-if="ruleForm.activityType == 2">
                                                <el-col :xs="24" :sm="24" :md="24" :lg="4">
                                                    <span>Projected Revenue: </span>
                                                </el-col>
                                                <el-col :xs="22" :sm="22" :md="22" :lg="20">
                                                    <el-form-item prop="projectedRevenue">
                                                        <el-input-number placeholder="Projected Revenue" v-model="ruleForm.projectedRevenue"></el-input-number>
                                                    </el-form-item>
                                                </el-col>
                                            </el-row>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <el-col :xs="24" :sm="24" :md="24" :lg="4">
                                                <span>Priority</span>
                                            </el-col>

                                            <el-col :xs="22" :sm="22" :md="22" :lg="20">
                                                <el-form-item prop="priority">
                                                    <el-select v-model="ruleForm.priority" placeholder="Select Priority">
                                                        <el-option
                                                                v-for="item in priorityTypes"
                                                                :key="item.value"
                                                                :label="item.label"
                                                                :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </el-form-item>
                                            </el-col>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <el-col :xs="24" :sm="24" :md="24" :lg="4">
                                                <span>Due Date</span>
                                            </el-col>
                                            <el-col :xs="22" :sm="22" :md="22" :lg="20">
                                                @{{ activityData.due_date }}
                                            </el-col>
                                        </div>
                                    </el-form>

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <hr>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <el-button type="primary" @click="addTask('ruleForm')">Save</el-button>
                                    </div>

                                </div>
                            </el-tab-pane>
                            <el-tab-pane label="Comments" name="second">

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="min-height: 500px; max-height: 800px; overflow: auto;">

                                    <el-popover
                                            ref="popover1"
                                            placement="top-start"
                                            title="Attach a file"
                                            width="500"
                                            trigger="click">
                                        <ul style="list-style:none">
                                            <el-upload
                                                    class="upload-demo"
                                                    ref="upload"
                                                    action="/activity/comment"
                                                    :data="data"
                                                    :on-change="checkIfFileIsSelected"
                                                    :on-remove="removeFileSelected"
                                                    :auto-upload="false">
                                                <el-button slot="trigger" size="small" type="primary">Select</el-button>
                                                <div class="el-upload__tip" slot="tip">files with a size less than 500kb</div>
                                            </el-upload>
                                        </ul>
                                    </el-popover>

                                    <ol class="chat" v-if="commentsData.length != 0">
                                        <div v-for="comment in commentsData">

                                            <div v-if="comment.user_id == 5">
                                                <li class="self">
                                                    <div class="avatar"><img :src="comment.avatar" draggable="false"/></div>
                                                    <div class="msg">
                                                        <p v-html="comment.comment"></p>
                                                        <div v-if="comment.files.length != 0">
                                                            <div v-for="file in comment.files">
                                                                <img v-if="file.image == true" :src="file.path" draggable="false"/>
                                                                <a v-if="file.image == false" class="edit" :href="file.path" download>
                                                                    <i class="fa fa-paperclip" aria-hidden="true"></i> &nbsp; @{{ file.name
                                                            }}</a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <time>@{{ comment.time }}</time>
                                                        </div>
                                                    </div>
                                                </li>
                                            </div>

                                            <div v-if="comment.user_id != 5">
                                                <li class="other">
                                                    <div class="avatar"><img :src="comment.avatar" draggable="false"/></div>
                                                    <div class="msg">
                                                        <p class="name">@{{ comment.username }}</p>
                                                        <p v-html="comment.comment"></p>
                                                        <div v-if="comment.files.length != 0">
                                                            <div v-for="file in comment.files">
                                                                <img v-if="file.image == true" :src="file.path" draggable="false"/>
                                                                <a v-if="file.image == false" class="edit" :href="file.path" download>
                                                                    <i class="fa fa-paperclip" aria-hidden="true"></i> &nbsp; @{{ file.name
                                                            }}</a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <time>@{{ comment.time }}</time>
                                                        </div>
                                                    </div>
                                                </li>
                                            </div>
                                        </div>
                                    </ol>

                                    <div class="row" style="margin-bottom: 20px" v-if="commentsData.length == 0">
                                        <el-alert
                                                title="No comments posted!"
                                                type="info"
                                                show-icon>
                                        </el-alert>
                                    </div>

                                    <el-input placeholder="Please input" v-model="input">
                                        <el-button slot="prepend" v-popover:popover1>Attach</el-button>
                                        <el-button @click="postComment" slot="append">Post</el-button>
                                    </el-input>

                                </div>
                            </el-tab-pane>
                            <el-tab-pane label="Progress" name="third">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="min-height: 500px; max-height: 800px; overflow: auto;">

                                    <el-dialog
                                            title="Update task progress"
                                            :visible.sync="updateTaskProgressDialogVisible"
                                            size="small">
                                        <el-row :span="24">

                                            <el-form :model="progressRuleForm" :rules="progressRules" ref="progressRuleForm" label-position="left">

                                                <div class="form-item-container">
                                                    <el-row :span="24" :gutter="20">
                                                        <el-col :xs="24" :sm="24" :md="24" :lg="4">
                                                            <span>Progress Description: </span>
                                                        </el-col>
                                                        <el-col :xs="22" :sm="22" :md="22" :lg="20">
                                                            <el-form-item prop="description">
                                                                <el-input placeholder="Progress Description"
                                                                          type="textarea"
                                                                          :rows="3"
                                                                          v-model="progressRuleForm.description"></el-input>
                                                            </el-form-item>
                                                        </el-col>
                                                    </el-row>

                                                    <el-row :span="24" :gutter="20">
                                                        <el-col :xs="24" :sm="24" :md="24" :lg="4">
                                                            <span>Status: </span>
                                                        </el-col>

                                                        <el-col :xs="22" :sm="22" :md="22" :lg="20">
                                                            <el-form-item prop="status">
                                                                <el-select v-model="progressRuleForm.status" placeholder="Select Status">
                                                                    <el-option
                                                                            v-for="item in progressUpdateStatuses"
                                                                            :key="item.value"
                                                                            :label="item.label"
                                                                            :value="item.value">
                                                                    </el-option>
                                                                </el-select>
                                                            </el-form-item>
                                                        </el-col>
                                                    </el-row>

                                                    <el-row :span="24" :gutter="20">
                                                        <el-col :xs="24" :sm="24" :md="24" :lg="4">
                                                            <span>Progress Percentage: </span>
                                                        </el-col>
                                                        <el-col :xs="22" :sm="22" :md="22" :lg="20">
                                                            <el-form-item prop="percentage">
                                                                <el-input-number placeholder="Progress Percentage"
                                                                                 :min="0"
                                                                                 :max="100"
                                                                                 v-model="progressRuleForm.percentage"></el-input-number>
                                                            </el-form-item>
                                                        </el-col>
                                                    </el-row>

                                                    <el-row :span="24" :gutter="20">
                                                        <el-col :xs="24" :sm="24" :md="24" :lg="4">
                                                            <span>File: </span>
                                                        </el-col>

                                                        <el-col :xs="22" :sm="22" :md="22" :lg="20">
                                                            <el-form-item prop="file">
                                                                <el-upload
                                                                        class="upload-demo"
                                                                        ref="progressUpload"
                                                                        action="/activity/progress/update"
                                                                        :data="progressData"
                                                                        :multiple="false"
                                                                        :on-change="checkIfProgressFileIsSelected"
                                                                        :on-remove="removeProgressFileSelected"
                                                                        :auto-upload="false">
                                                                    <el-button size="small" type="primary">Click to upload</el-button>
                                                                    <div slot="tip" class="el-upload__tip">jpg/png files with a size less than 500kb</div>
                                                                </el-upload>
                                                            </el-form-item>
                                                        </el-col>
                                                    </el-row>
                                                </div>

                                                <hr>

                                                <div class="form-item-container">
                                            <span slot="footer" class="dialog-footer">
                                                <el-button @click="updateTaskProgressDialogVisible = false">Cancel</el-button>
                                                <el-button type="primary" @click="addProgressUpdate('progressRuleForm')">Save</el-button>
                                            </span>
                                                </div>

                                            </el-form>

                                        </el-row>
                                    </el-dialog>

                                    <div style="background-color: white; margin-bottom: 20px">
                                        <el-button type="primary" @click="showAddTaskProgress">Update Progress</el-button>
                                    </div>

                                    <div class="form-item-container" v-if="progressUpdateData.length != 0" v-for="progressUpdate in progressUpdateData">
                                        <el-card class="box-card" style="margin-bottom: 20px">
                                            <p>@{{ progressUpdate.name }}</p>
                                            <p>@{{ progressUpdate.description }}</p>
                                            <el-progress :percentage="progressUpdate.percentage"></el-progress>
                                            <hr>
                                            <el-row :span="24" :gutter="20">
                                                <el-col :span="2" v-if="progressUpdate.progress_files.length != 0">
                                                    <el-badge :value="progressUpdate.progress_files.length" class="item">
                                                        <button class="btn" @click="showTaskProgressFiles(progressUpdate.progress_files)"><i class="fa fa-file font-icon" aria-hidden="true"></i></button>
                                                    </el-badge>
                                                </el-col>
                                            </el-row>
                                        </el-card>
                                    </div>

                                    <div class="row" style="margin-bottom: 20px" v-if="progressUpdateData.length == 0">
                                        <el-alert
                                                title="No comments posted!"
                                                type="info"
                                                show-icon>
                                        </el-alert>
                                    </div>
                                </div>
                            </el-tab-pane>
                        </el-tabs>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <v-calendar
                                mode='single'
                                :theme-styles='themeStyles'
                                :attributes='attributes'
                                is-inline>
                        </v-calendar>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="min-height: 200px; margin-top: 20px; background-color: white; padding-bottom: 20px">
                            <div class="col-lg-1 avatar-circle" v-for="watcher in watchersData" v-bind:class="themeArr[changeColor()]">
                                <el-tooltip class="item" effect="dark" v-bind:content=watcher.name placement="top-start">
                            <span class="initials">
                                @{{ watcher.initials }}
                            </span>
                                </el-tooltip>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <hr>
                                @if(in_array(23, getPermissions()))
                                    <div v-if="activityData.isWatcher">
                                        <el-button @click="toggleWatcher()">Stop watching</el-button>
                                    </div>

                                    <div v-if="!activityData.isWatcher">
                                        <el-button @click="toggleWatcher()">Start watching</el-button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </individual-activity>
        </div>
    </div>

@stop