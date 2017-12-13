@extends('dashboard.default')


@section('dashboard-content')

    <div class="row">
        <div class="col-lg-12">
            <activities user-id="{!! $user->id !!}" inline-template>
                <div>
                    <el-row :span="24" :gutter="20">
                        <el-form :model="searchForm" :rules="searchRules" ref="searchForm" label-position="top"
                                 style="padding-left: 30px">

                            <el-col :span="2">
                                <el-form-item prop="filter" label="Filter By:">
                                </el-form-item>
                            </el-col>

                            <el-col :span="5">
                                <el-form-item prop="startDate" label="From date:">
                                    <el-date-picker
                                            v-model="searchForm.startDate"
                                            type="date"
                                            placeholder="Start Date">
                                    </el-date-picker>
                                </el-form-item>
                            </el-col>

                            <el-col :span="5">
                                <el-form-item prop="endDate" label="To date:">
                                    <el-date-picker
                                            v-model="searchForm.endDate"
                                            type="date"
                                            placeholder="End Date">
                                    </el-date-picker>
                                </el-form-item>
                            </el-col>

                            <el-col :span="5">
                                <el-form-item prop="priority" label="Priority:">
                                    <el-select v-model="searchForm.priority" placeholder="Select Priority">
                                        <el-option
                                                v-for="item in priorityTypes"
                                                :key="item.value"
                                                :label="item.label"
                                                :value="item.value">
                                        </el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>

                            @if(in_array(12, getPermissions()))
                                <el-col :span="5">
                                    <el-form-item prop="user" label="User:">
                                        <el-select v-model="searchForm.user" placeholder="Select User">
                                            <el-option
                                                    v-for="item in users"
                                                    :key="item.value"
                                                    :label="item.label"
                                                    :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </el-form-item>
                                </el-col>
                            @endif
                            <el-col :span="2">
                                <el-form-item prop="search" style="margin-top: 30px">
                                    <el-button type="primary" @click="searchActivities()">Search</el-button>
                                </el-form-item>
                            </el-col>

                        </el-form>
                    </el-row>

                    <el-row :span="24" :gutter="20">
                        <el-col :span="6">
                            <div class="panel panel-primary to-do-panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">To Do</h3>
                                </div>
                                <div class="panel-body">
                                    <draggable
                                            id="1"
                                            class="dragArea"
                                            v-model="todo"
                                            :options="{group:'people'}"
                                            :move="showMove"
                                    @end="onEnd">
                                    <div class="dragElements" v-for="element in todo" :key="element.id">
                                        <div>
                                            <el-row :span="24">
                                                <el-col :span="12"><span v-if="element.priority_type == 'Low'"
                                                                         class="low-priority-span">Low Priority</span></el-col>
                                                <el-col :span="12"><span v-if="element.priority_type == 'Medium'" class="med-priority-span">Med Priority</span>
                                                </el-col>
                                                <el-col :span="12"><span v-if="element.priority_type == 'High'" class="high-priority-span">High Priority</span>
                                                </el-col>
                                                <el-col :span="12" style="text-align: right">
                                                    <a href="#" @click="showTaskWatchDialog(element)"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                </el-col>
                                            </el-row>
                                        </div>

                                        <div class="element-container">@{{ element.name }}</div>
                                        <el-row :span="24" :gutter="20">
                                            <el-col :span="4">
                                                <el-badge :value="element.comments.length" class="item">
                                                    <button class="btn" @click="getSelectedTask(element)"><i
                                                            class="fa fa-comment font-icon" aria-hidden="true"></i></button>
                                                </el-badge>
                                            </el-col>
                                            <el-col :span="4">
                                                <el-badge :value="element.countProgressUpdates" class="item">
                                                    <button class="btn" @click="showTaskProgress(element)"><i class="fa fa-tasks font-icon" aria-hidden="true"></i></button>
                                                </el-badge>
                                            </el-col>
                                        </el-row>
                                    </div>
                                    </draggable>
                                </div>
                                <div class="panel-footer" style="text-align: center">
                                    <el-button type="primary" @click="taskDialogVisible = true" size="mini">Add Task</el-button>
                                </div>
                            </div>
                        </el-col>

                        <el-col :span="6">
                            <div class="panel panel-warning in-progress-panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">In Progress</h3>
                                </div>
                                <div class="panel-body">
                                    <draggable
                                            id="2"
                                            class="dragArea"
                                            v-model="inProgress"
                                            :options="{group:'people'}"
                                            :move="showMove"
                                    @end="onEnd">
                                    <div class="dragElements" v-for="element in inProgress">
                                        <div>
                                            <el-row :span="24">
                                                <el-col :span="12"><span v-if="element.priority_type == 'Low'"
                                                                         class="low-priority-span">Low Priority</span></el-col>
                                                <el-col :span="12"><span v-if="element.priority_type == 'Medium'" class="med-priority-span">Med Priority</span>
                                                </el-col>
                                                <el-col :span="12"><span v-if="element.priority_type == 'High'" class="high-priority-span">High Priority</span>
                                                </el-col>
                                                <el-col :span="12" style="text-align: right">
                                                    <a href="#" @click="showTaskWatchDialog(element)"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                </el-col>
                                            </el-row>
                                        </div>

                                        <div class="element-container">@{{ element.name }}</div>
                                        <el-row :span="24" :gutter="20">
                                            <el-col :span="4">
                                                <el-badge :value="element.comments.length" class="item">
                                                    <button class="btn" @click="getSelectedTask(element)"><i
                                                            class="fa fa-comment font-icon" aria-hidden="true"></i></button>
                                                </el-badge>
                                            </el-col>
                                            <el-col :span="4">
                                                <el-badge :value="element.countProgressUpdates" class="item">
                                                    <button class="btn" @click="showTaskProgress(element)"><i class="fa fa-tasks font-icon" aria-hidden="true"></i></button>
                                                </el-badge>
                                            </el-col>
                                        </el-row>
                                    </div>
                                    </draggable>
                                </div>
                            </div>
                        </el-col>

                        <el-col :span="6">
                            <div class="panel panel-info in-review-panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Review</h3>
                                </div>
                                <div class="panel-body">
                                    <draggable
                                            id="3"
                                            class="dragArea"
                                            v-model="inReview"
                                            :options="{group:'people'}"
                                            :move="showMove"
                                    @end="onEnd">
                                    <div class="dragElements" v-for="element in inReview">
                                        <div>
                                            <el-row :span="24">
                                                <el-col :span="12"><span v-if="element.priority_type == 'Low'"
                                                                         class="low-priority-span">Low Priority</span></el-col>
                                                <el-col :span="12"><span v-if="element.priority_type == 'Medium'" class="med-priority-span">Med Priority</span>
                                                </el-col>
                                                <el-col :span="12"><span v-if="element.priority_type == 'High'" class="high-priority-span">High Priority</span>
                                                </el-col>
                                                <el-col :span="12" style="text-align: right">
                                                    <a href="#" @click="showTaskWatchDialog(element)"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                </el-col>
                                            </el-row>
                                        </div>

                                        <div class="element-container">@{{ element.name }}</div>
                                        <el-row :span="24" :gutter="20">
                                            <el-col :span="4">
                                                <el-badge :value="element.comments.length" class="item">
                                                    <button class="btn" @click="getSelectedTask(element)"><i
                                                            class="fa fa-comment font-icon" aria-hidden="true"></i></button>
                                                </el-badge>
                                            </el-col>
                                            <el-col :span="4">
                                                <el-badge :value="element.countProgressUpdates" class="item">
                                                    <button class="btn" @click="showTaskProgress(element)"><i class="fa fa-tasks font-icon" aria-hidden="true"></i></button>
                                                </el-badge>
                                            </el-col>
                                        </el-row>
                                    </div>
                                    </draggable>
                                </div>
                            </div>
                        </el-col>

                        <el-col :span="6">
                            <div class="panel panel-success done-panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Complete</h3>
                                </div>
                                <div class="panel-body">
                                    <draggable
                                            id="4"
                                            class="dragArea"
                                            v-model="done"
                                            :options="{group:'people'}"
                                            :move="showMove"
                                    @end="onEnd">
                                    <div class="dragElements" v-for="element in done">
                                        <div>
                                            <el-row :span="24">
                                                <el-col :span="12"><span v-if="element.priority_type == 'Low'"
                                                                         class="low-priority-span">Low Priority</span></el-col>
                                                <el-col :span="12"><span v-if="element.priority_type == 'Medium'" class="med-priority-span">Med Priority</span>
                                                </el-col>
                                                <el-col :span="12"><span v-if="element.priority_type == 'High'" class="high-priority-span">High Priority</span>
                                                </el-col>
                                            </el-row>
                                        </div>
                                        <div class="element-container">@{{ element.name }}</div>
                                        <el-row :span="24" :gutter="20">
                                            <el-col :span="4">
                                                <el-badge :value="element.comments.length" class="item">
                                                    <button class="btn" @click="getSelectedTask(element)"><i
                                                            class="fa fa-comment font-icon" aria-hidden="true"></i></button>
                                                </el-badge>
                                            </el-col>
                                            <el-col :span="4">
                                                <el-badge :value="element.countProgressUpdates" class="item">
                                                    <button class="btn" @click="showTaskProgress(element)"><i class="fa fa-tasks font-icon" aria-hidden="true"></i></button>
                                                </el-badge>
                                            </el-col>
                                        </el-row>
                                    </div>
                                    </draggable>
                                </div>
                            </div>
                        </el-col>
                    </el-row>

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

                    <el-dialog
                            title="Add/Edit Task"
                            :visible.sync="taskDialogVisible"
                            size="small">
                        <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-position="left">

                            <div class="form-item-container">
                                <el-row :span="24" :gutter="20">
                                    <el-col :span="4">
                                        <span>Activity: </span>
                                    </el-col>
                                    <el-col :span="20">
                                        <el-form-item prop="name">
                                            <el-input placeholder="Activity Name" v-model="ruleForm.name"></el-input>
                                        </el-form-item>
                                    </el-col>
                                </el-row>

                                <el-row :span="24" :gutter="20">
                                    <el-col :span="4">
                                        <span>Description: </span>
                                    </el-col>
                                    <el-col :span="20">
                                        <el-form-item prop="description">
                                            <el-input placeholder="Activity Description"
                                                      type="textarea"
                                                      :rows="3"
                                                      v-model="ruleForm.description"></el-input>
                                        </el-form-item>
                                    </el-col>
                                </el-row>

                                <el-row :span="24" :gutter="20">
                                    <el-col :span="4">
                                        <span>Activity Type: </span>
                                    </el-col>

                                    <el-col :span="20">
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
                                </el-row>

                                <el-row :span="24" :gutter="20" v-if="ruleForm.activityType == 2">
                                    <el-col :span="4">
                                        <span>Source: </span>
                                    </el-col>
                                    <el-col :span="20">
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

                                <el-row :span="24" :gutter="20" v-if="ruleForm.activityType == 2">
                                    <el-col :span="4">
                                        <span>Projected Revenue: </span>
                                    </el-col>
                                    <el-col :span="20">
                                        <el-form-item prop="projectedRevenue">
                                            <el-input-number placeholder="Projected Revenue" v-model="ruleForm.projectedRevenue"></el-input-number>
                                        </el-form-item>
                                    </el-col>
                                </el-row>

                                @if(in_array(12, getPermissions()))
                                    <el-row :span="24" :gutter="20">
                                        <el-col :span="4">
                                            <span>Assign To: </span>
                                        </el-col>

                                        <el-col :span="20">
                                            <el-form-item prop="user">
                                                <el-select v-model="ruleForm.user" placeholder="Select User">
                                                    <el-option
                                                            v-for="item in users"
                                                            :key="item.value"
                                                            :label="item.label"
                                                            :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </el-form-item>
                                        </el-col>
                                    </el-row>
                                @endif

                                <el-row :span="24" :gutter="20">
                                    <el-col :span="4">
                                        <span>Priority</span>
                                    </el-col>

                                    <el-col :span="20">
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
                                </el-row>


                                <el-row :span="24" :gutter="20">
                                    <el-col :span="4">
                                        <span>Due Date</span>
                                    </el-col>
                                    <el-col :span="20">
                                        <el-form-item prop="dueDate">
                                            <el-date-picker
                                                    v-model="ruleForm.dueDate"
                                                    type="date"
                                                    format="dd-MM-yyyy"
                                                    placeholder="Due Date">
                                            </el-date-picker>
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                            </div>

                            <hr>

                        </el-form>

                        <div class="form-item-container">
                <span slot="footer" class="dialog-footer">
                    <el-button @click="taskDialogVisible = false">Cancel</el-button>
                    <el-button type="primary" @click="addTask('ruleForm')">Save</el-button>
                  </span>
                        </div>
                    </el-dialog>

                    <el-dialog
                            title="Comments"
                            class="comment-container"
                            :visible.sync="commentsDialog"
                            size="small">
                        <span><strong>Activity Name: </strong>@{{ selectedTask.name }}</span>

                        <ol class="chat" v-if="selectedTask.comments.length != 0">
                            <div v-for="comment in selectedTask.comments">

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

                        <div slot="footer" class="dialog-footer">

                            <el-input placeholder="Please input" v-model="input">
                                <el-button slot="prepend" v-popover:popover1>Attach</el-button>
                                <el-button @click="postComment" slot="append">Post</el-button>
                            </el-input>
                        </div>
                    </el-dialog>

                    <el-dialog
                            title="Watch Task"
                            :visible.sync="watchTaskDialogVisible"
                            size="small">
                        <el-row :span="24">
                            <div v-if="selectedTask.isWatcher">
                                <h5>You are watching this task</h5>
                                <p>Stop watching this task to stop updates</p>
                                <el-button @click="toggleWatcher()">Stop watching</el-button>
                            </div>

                            <div v-if="!selectedTask.isWatcher">
                                <h5>You are not watching this task</h5>
                                <p>Start watching this task to receive updates</p>
                                <el-button @click="toggleWatcher()">Start watching</el-button>
                            </div>

                            <hr>

                            <p>Others watching</p>

                            <ul v-for="watcher in selectedTask.watchers" style="list-style: none">
                                <li>@{{ watcher.name }}</li>
                            </ul>
                        </el-row>
                    </el-dialog>

                    <el-dialog
                            title="Update task progress"
                            :visible.sync="updateTaskProgressDialogVisible"
                            size="small">
                        <el-row :span="24">

                            <el-form :model="progressRuleForm" :rules="progressRules" ref="progressRuleForm" label-position="left">

                                <div class="form-item-container">
                                    <el-row :span="24" :gutter="20">
                                        <el-col :span="4">
                                            <span>Progress Description: </span>
                                        </el-col>
                                        <el-col :span="20">
                                            <el-form-item prop="description">
                                                <el-input placeholder="Progress Description"
                                                          type="textarea"
                                                          :rows="3"
                                                          v-model="progressRuleForm.description"></el-input>
                                            </el-form-item>
                                        </el-col>
                                    </el-row>

                                    <el-row :span="24" :gutter="20">
                                        <el-col :span="4">
                                            <span>Status: </span>
                                        </el-col>

                                        <el-col :span="20">
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
                                        <el-col :span="4">
                                            <span>Progress Percentage: </span>
                                        </el-col>
                                        <el-col :span="20">
                                            <el-form-item prop="percentage">
                                                <el-input-number placeholder="Progress Percentage"
                                                                 :min="0"
                                                                 :max="100"
                                                                 v-model="progressRuleForm.percentage"></el-input-number>
                                            </el-form-item>
                                        </el-col>
                                    </el-row>

                                    <el-row :span="24" :gutter="20">
                                        <el-col :span="4">
                                            <span>File: </span>
                                        </el-col>

                                        <el-col :span="20">
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

                    <el-dialog
                            title="Task Progress"
                            class="task-progress-update"
                            :visible.sync="taskProgressDialogVisible"
                            size="small">
                        <el-row :span="24">

                            <div class="form-item-container" v-for="progressUpdate in progressUpdateData">
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
                        </el-row>
                        <div slot="footer" class="dialog-footer">
                            <el-button @click="taskProgressDialogVisible = false">Cancel</el-button>
                            <el-button type="primary" @click="showAddTaskProgress">Update Progress</el-button>
                        </div>
                    </el-dialog>

                    <el-dialog
                            title="Task Progress Files"
                            :visible.sync="taskProgressFileDialogVisible"
                            size="small">
                        <el-row :span="24">
                            <ul style="list-style: none; padding-left:0px" v-for="file in selectedProgressUpdateFiles">
                                <li>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <a :href="file.path">@{{ file.name }}</a>
                                    </div>
                                    <div class="col-lg-12">
                                        <hr>
                                    </div>
                                </li>
                            </ul>

                        </el-row>
                        <div slot="footer" class="dialog-footer">
                            <el-button @click="taskProgressFileDialogVisible = false">Close</el-button>
                        </div>
                    </el-dialog>

                </div>
            </activities>
        </div>
    </div>
@stop