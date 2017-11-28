<template>
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
                                            <el-button @click="showTaskWatchDialog(element)"><i class="fa fa-eye" aria-hidden="true"></i></el-button>
                                        </el-col>
                                    </el-row>
                                </div>

                                <div class="element-container">{{ element.name }}</div>
                                <el-row :span="24" :gutter="20">
                                    <el-col :span="12">
                                        <button class="btn" @click="getSelectedTask(element)"><i
                                                class="fa fa-comment font-icon" aria-hidden="true"></i> &nbsp; {{element.comments.length }}</button>
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
                                            <el-button @click="showTaskWatchDialog(element)"><i class="fa fa-eye" aria-hidden="true"></i></el-button>
                                        </el-col>
                                    </el-row>
                                </div>

                                <div class="element-container">{{ element.name }}</div>
                                <el-row :span="24" :gutter="20">
                                    <el-col :span="12">
                                        <button class="btn" @click="getSelectedTask(element)"><i
                                                class="fa fa-comment font-icon" aria-hidden="true"></i> &nbsp; {{element.comments.length }}</button>
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
                                            <el-button @click="showTaskWatchDialog(element)"><i class="fa fa-eye" aria-hidden="true"></i></el-button>
                                        </el-col>
                                    </el-row>
                                </div>

                                <div class="element-container">{{ element.name }}</div>
                                <el-row :span="24" :gutter="20">
                                    <el-col :span="12">
                                        <button class="btn" @click="getSelectedTask(element)"><i
                                                class="fa fa-comment font-icon" aria-hidden="true"></i> &nbsp; {{element.comments.length }}</button>
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
                                <div class="element-container">{{ element.name }}</div>
                                <el-row :span="24" :gutter="20">
                                    <el-col :span="12">
                                        <button class="btn" @click="getSelectedTask(element)"><i
                                                class="fa fa-comment font-icon" aria-hidden="true"></i> &nbsp; {{element.comments.length }}</button>
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
            <span><strong>Activity Name: </strong>{{ selectedTask.name }}</span>

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
                                            <i class="fa fa-paperclip" aria-hidden="true"></i> &nbsp; {{ file.name
                                            }}</a>
                                    </div>
                                </div>
                                <div>
                                    <time>{{ comment.time }}</time>
                                </div>
                            </div>
                        </li>
                    </div>

                    <div v-if="comment.user_id != 5">
                        <li class="other">
                            <div class="avatar"><img :src="comment.avatar" draggable="false"/></div>
                            <div class="msg">
                                <p class="name">{{ comment.username }}</p>
                                <p v-html="comment.comment"></p>
                                <div v-if="comment.files.length != 0">
                                    <div v-for="file in comment.files">
                                        <img v-if="file.image == true" :src="file.path" draggable="false"/>
                                        <a v-if="file.image == false" class="edit" :href="file.path" download>
                                            <i class="fa fa-paperclip" aria-hidden="true"></i> &nbsp; {{ file.name
                                            }}</a>
                                    </div>
                                </div>
                                <div>
                                    <time>{{ comment.time }}</time>
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
                    <li>{{ watcher.name }}</li>
                </ul>
            </el-row>
        </el-dialog>

    </div>


</template>

<script>

    import draggable from 'vuedraggable';

    export default{
        components: {draggable},
        props: ['userId'],
        data (){
            return {
                file: false,
                data: {
                    comment: '',
                    activity_id: ''
                },
                input: '',
                selectedTask: {
                    'comments': []
                },
                todo: [],
                inProgress: [],
                inReview: [],
                done: [],
                taskDialogVisible: false,
                watchTaskDialogVisible: false,
                commentsDialog: false,
                activity_status_id: '',
                targetElementName: '',
                draggedElement: '',
                from: '',
                to: '',
                users: [],
                statuses: [],
                priorityTypes: [],
                options: [{
                    value: '1',
                    label: 'Active'
                }, {
                    value: '0',
                    label: 'Inactive'
                }],
                ruleForm: {
                    name: '',
                    description: '',
                    user: '',
                    priority: '',
                    dueDate: '',
                },
                searchForm: {
                    startDate: '',
                    endDate: '',
                    user: '',
                    priority: '',
                },
                searchRules: {
                    startDate: [
                        {required: false, message: 'Please input start date', trigger: 'blur', type: 'date'},
                    ],
                    endDate: [
                        {required: false, message: 'Please input end date', trigger: 'blur', type: 'date'},
                    ],
                    user: [
                        {required: false, message: 'Please select user', trigger: 'change'},
                    ],
//                    priority: [
//                        {required: false, message: 'Please select status', trigger: 'change'},
//                    ],
                },
                rules: {
                    name: [
                        {required: true, message: 'Please input activity name', trigger: 'blur'},
                    ],
                    description: [
                        {required: true, message: 'Please input activity description', trigger: 'blur'},
                    ],
                    user: [
                        {required: false, message: 'Please select user', trigger: 'change', type: 'number'},
                    ],
//                    priority: [
//                        {required: false, message: 'Please select priority', trigger: 'change'},
//                    ],
                    dueDate: [
                        {required: true, message: 'Please input due date', trigger: 'blur', type: 'date'},
                    ],
                },
            }
        },
        created: function () {

            let vm = this;

            vm.getInformation();

            vm.getActivities();
        },
        methods: {
            removeFileSelected()
            {
                let vm = this;

                vm.file = false;
            },

            checkIfFileIsSelected(file)
            {
                let vm = this;

                vm.file = true;

                if (file.response != undefined && file.response.success) {
                    vm.selectedTask.comments.push(file.response.uploadedComment);

                    vm.input = '';

                    vm.scrollToEnd();
                }

            },

            showMove(evt, originalEvent){
                let vm = this;

                vm.draggedElement = evt.draggedContext;

                vm.from = evt.from.id;

                vm.to = evt.to.id;
            },

            onEnd(evt){
                let vm = this;

                console.log(vm.draggedElement.element.user_id, vm.userId);

                if (vm.draggedElement.element.user_id != vm.userId)
                {
                    vm.$message({
                        type: 'error',
                        message: 'You cannot update a task that does not belong to you'
                    });
                }
                else{
                    if (vm.from != vm.to) {
                        axios.post('/update/activities', {
                            activity_id: vm.draggedElement.element.id,
                            activity_status_id: vm.to
                        })
                            .then(function (response) {

                                if (response.data.success) {
                                    vm.$message({
                                        type: 'success',
                                        message: response.data.message
                                    });
                                }
                                else {
                                    vm.$message({
                                        type: 'error',
                                        message: response.data.message
                                    });
                                }
                            }).catch(function (error) {
                            console.log(error);
                        });
                    }
                }
            },

            getInformation()
            {
                let vm = this;
                axios.get('/activities/info')
                    .then(function (response) {
                        vm.users = response.data.users;
                        vm.priorityTypes = response.data.priorities;
                    }).catch(function (error) {
                    console.log(error);
                })
            },

            getActivities()
            {
                let vm = this;
                axios.get('/api/activities')
                    .then(function (response) {
                        vm.todo = (response.data.todo == undefined) ? [] : response.data.todo;
                        vm.inProgress = (response.data.progress == undefined) ? [] : response.data.progress;
                        vm.inReview = (response.data.review == undefined) ? [] : response.data.review;
                        vm.done = (response.data.done == undefined) ? [] : response.data.done;
                    }).catch(function (error) {
                    console.log(error);
                })
            },

            addTask(formName)
            {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        let vm = this;

                        vm.$message({
                            type: 'info',
                            message: 'Saving Task'
                        });

                        axios.post('/activity/save', {
                            type: 1,
                            name: vm.ruleForm.name,
                            description: vm.ruleForm.description,
                            user_id: vm.ruleForm.user,
                            priority_type_id: vm.ruleForm.priority,
                            due_date: vm.ruleForm.dueDate + '',
                            activity_status_id: 1
                        })
                            .then(function (response) {
                                vm.taskDialogVisible = false;

                                if (response.data.success) {
                                    vm.$message({
                                        type: 'success',
                                        message: response.data.message
                                    });

                                    vm.getActivities();

                                    vm.$refs[formName].resetFields();
                                }
                                else {
                                    vm.$message({
                                        type: 'error',
                                        message: response.data.message
                                    });
                                }
                            }).catch(function (error) {
                            console.log(error);
                        });
                    } else {
                        return false;
                    }
                });
            },

            getSelectedTask(task)
            {
                let vm = this;

                vm.commentsDialog = true;

                vm.selectedTask = task;

                vm.scrollToEnd();
            },

            postComment()
            {
                let vm = this;

                if (vm.file) {

                    vm.data.comment = vm.input;

                    vm.data.activity_id = vm.selectedTask.id;

                    vm.$refs.upload.submit();
                }
                else {
                    axios.post('/activity/comment', {
                        activity_id: vm.selectedTask.id,
                        comment: vm.input
                    })
                        .then(function (response) {

                            vm.input = '';

                            vm.selectedTask.comments.push(response.data.uploadedComment);

                            vm.scrollToEnd();

                            if (response.data.success) {
                                vm.$message({
                                    type: 'success',
                                    message: response.data.message
                                });

                            }
                            else {
                                vm.$message({
                                    type: 'error',
                                    message: response.data.message
                                });
                            }
                        }).catch(function (error) {
                        console.log(error);
                    });
                }
            },

            showTaskWatchDialog(task)
            {
                let vm = this;

                vm.watchTaskDialogVisible = true;

                vm.selectedTask = task;
            },

            toggleWatcher()
            {
                let vm = this;

                axios.post('/activity/watch', {
                    activity_id: vm.selectedTask.id,
                    watch: !vm.selectedTask.isWatcher
                })
                    .then(function (response) {

                        if (response.data.success) {
                            vm.$message({
                                type: 'success',
                                message: response.data.message
                            });

                            vm.selectedTask.isWatcher = response.data.isWatcher;

                            vm.selectedTask.watchers = response.data.watchers;
                        }
                        else {
                            vm.$message({
                                type: 'error',
                                message: response.data.message
                            });
                        }
                    }).catch(function (error) {
                    console.log(error);
                });
            },

            searchActivities()
            {
                let vm = this;

                vm.$message({
                    type: 'info',
                    message: 'Searching...'
                });

                let user = vm.userId;

                if (vm.searchForm.user != '')
                {
                    user = vm.searchForm.user;
                }

                axios.post('/activity/search', {
                    startDate: vm.searchForm.startDate+"",
                    endDate: vm.searchForm.endDate+"",
                    priority: vm.searchForm.priority,
                    userId: user,
                })
                    .then(function (response) {

                        if (response.data.success) {
                            vm.$message({
                                type: 'success',
                                message: response.data.message
                            });

                            vm.todo = (response.data.activities.todo == undefined) ? [] : response.data.activities.todo;
                            vm.inProgress = (response.data.activities.progress == undefined) ? [] : response.data.activities.progress;
                            vm.inReview = (response.data.activities.review == undefined) ? [] : response.data.activities.review;
                            vm.done = (response.data.activities.done == undefined) ? [] : response.data.activities.done;
                        }
                        else {
                            vm.$message({
                                type: 'error',
                                message: response.data.message
                            });
                        }
                    }).catch(function (error) {
                    console.log(error);
                });
            },

            scrollToEnd: function () {
                let vm = this;

                let container = vm.$el.querySelector(".el-dialog__body");

                container.scrollTop = container.scrollHeight;
            },
        }
    }
</script>

<style>
    .comment-container .el-dialog__body {
        padding: 20px 20px;
        max-height: 700px;
        overflow: hidden;
        overflow-y: scroll;
    }

    .el-select {
        width: 100%;
    }

    .el-date-editor.el-input {
        width: 100%;
    }

    .dragArea {
        min-height: 50px;
    }

    .dragElements {
        margin: 15px 10px 0px 10px;
        background-color: #ffffff;
        min-height: 100px;
        border-radius: 5px;
        color: black;
        padding: 10px;
    }

    .element-container {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .to-do-panel {
        border-color: transparent;
        border-top: 5px solid #e43e52;
        background-color: #f7f8fc !important;
    }

    .panel-heading {
        color: black !important;
        background-color: transparent !important;
        border-color: transparent !important;
    }

    .in-progress-panel {
        border-color: transparent;
        border-top: 5px solid #f5a622;
        background-color: #f7f8fc !important;
    }

    .in-review-panel {
        border-color: transparent;
        border-top: 5px solid #4b8fe3;
        background-color: #f7f8fc !important;
    }

    .done-panel {
        border-color: transparent;
        border-top: 5px solid #12884b;
        background-color: #f7f8fc !important;
    }

    .low-priority-span {
        padding: 5px 10px 5px 10px;
        background-color: #4b8fe3;
        color: white;
        border-radius: 5px;
        font-size: 12px;
    }

    .med-priority-span {
        padding: 5px 10px 5px 10px;
        background-color: #12884b;
        color: white;
        border-radius: 5px;
        font-size: 12px;
    }

    .high-priority-span {
        padding: 5px 10px 5px 10px;
        background-color: #e43e52;
        color: white;
        border-radius: 5px;
        font-size: 12px;
    }

    .chat {
        list-style: none;
        background: none;
        margin: 0;
        margin-top: 60px;
        margin-bottom: 50px;
        min-height: 500px;
        overflow: auto;
    }

    .chat li {
        padding: 0.5rem;
        overflow: hidden;
        display: flex;
    }

    .chat .avatar {
        width: 40px;
        height: 40px;
        position: relative;
        display: block;
        z-index: 2;
        border-radius: 100%;
        -webkit-border-radius: 100%;
        -moz-border-radius: 100%;
        -ms-border-radius: 100%;
        background-color: rgba(255, 255, 255, 0.9);
    }

    .chat .avatar img {
        width: 40px;
        height: 40px;
        border-radius: 100%;
        -webkit-border-radius: 100%;
        -moz-border-radius: 100%;
        -ms-border-radius: 100%;
        background-color: rgba(255, 255, 255, 0.9);
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }

    .other .msg {
        order: 1;
        margin-left: 15px;
        border-top-left-radius: 0px;
        box-shadow: -1px 2px 0px #d7e8f9;
    }

    .other:before {
        content: "";
        position: relative;
        top: 0px;
        right: 0px;
        left: 53px;
        width: 0px;
        height: 0px;
        border: 5px solid #f6f8fa;
        border-left-color: transparent;
        border-bottom-color: transparent;
    }

    .self {
        justify-content: flex-end;
        align-items: flex-end;
    }

    .self .msg {
        order: 1;
        margin-right: 15px;
        background-color: #d7e8f9;
        border-bottom-right-radius: 0px;
        box-shadow: 1px 2px 0px #d7e8f9;
    }

    .self .avatar {
        order: 2;
    }

    .self .avatar:after {
        content: "";
        position: relative;
        display: inline-block;
        bottom: 19px;
        right: 15px;
        width: 0px;
        height: 0px;
        border: 5px solid #fff;
        border-left-color: #d7e8f9;
        border-right-color: transparent;
        border-top-color: transparent;
        border-bottom-color: #d7e8f9;
        box-shadow: 0px 2px 0px #d7e8f9;
    }

    .msg {
        background: #f6f8fa;
        min-width: 50px;
        padding: 10px;
        border-radius: 2px;
        box-shadow: 0px 2px 0px rgba(0, 0, 0, 0.07);
    }

    .msg p {
        font-size: 14px;
        letter-spacing: 1px;
        margin: 0 0 0.2rem 0;
        color: #777;
    }

    .msg .name {
        font-size: 0.7em;
        color: #0000fe;
    }

    .msg img {
        position: relative;
        display: block;
        width: 300px;
        border-radius: 5px;
        box-shadow: 0px 0px 3px #eee;
        transition: all .4s cubic-bezier(0.565, -0.260, 0.255, 1.410);
        cursor: default;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }

    @media screen and (max-width: 800px) {
        .msg img {
            width: 300px;
        }
    }

    @media screen and (max-width: 550px) {
        .msg img {
            width: 200px;
        }
    }

    .msg img:hover {
        opacity: 0.4;
    }

    .msg time {
        font-size: 13px;
        color: #777;;
        margin-top: 5px;
        float: right;
        cursor: default;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }

    .msg time:before {
        content: "\f017";
        color: #777;
        font-family: FontAwesome;
        display: inline-block;
        margin-right: 4px;
    }

    .msg .edit {
        font-size: 12px;
        color: #777;;
        margin-top: 5px;
        float: left;
    }

    .chat-comments-control input[type="text"].comment-box {
        bottom: 0;
        width: 90%;
        padding: 5px;
        font-size: 0.9rem;
        color: #777;
        height: 50px;
        float: left;
        background-color: transparent !important;
        border-style: none !important;
        border-color: transparent !important;
        box-shadow: none !important;
    }

    input[type="submit"] .send {
        background-color: #42ff55;
    }

    .chat-comments-control {
        border-top: solid 1px #d7e8f9;
        width: 90%;
        height: 50px;
        border-radius: 2px;
        margin: auto;
        margin-top: 5px;
    }

    .attachbox {
        float: left;
        width: 70px;
        height: 100%;
        margin-right: 10px;
    }

    .attachbox .clip {
        color: #d7e8f9;
        font-size: 25px;
        margin-top: 10px;
        float: right;
    }

    .attachbox .image {
        color: #d7e8f9;
        font-size: 25px;
        margin-top: 10px;
        float: left;
    }

    .sendbox {
        float: right;
        width: 20px;
        height: 100%;
        margin-right: 10px;
    }

    .sendbox .send {
        color: #d7e8f9;
        font-size: 25px;
        background-color: white;
        float: left;
    }

    .clip:hover {
        font-size: 35px;
    }

    .image:hover {
        font-size: 35px;
    }

    .holder {
        width: 80%;
        background: white;
        position: fixed;
        bottom: 0;
        margin-left: -1%;
        margin-top: 10px;
        height: 80px;
    }

    .load-more {
        background-color: #66b0fb;
        margin-left: 200px;
        margin-right: 200px;
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .load-more:hover {
        background-color: #4c91d7;
    }

    .component-users {
        background: #006B5B;
        color: #FFFFFF;
        margin-right: 5px;
        font-weight: 300;
        padding: 2px 10px;
        border-radius: 3px;
        line-height: 20px;
        font-size: 12px;
        display: inline-flex;
        margin-top: 10px;
    }

    .component-remove {
        margin-left: 5px;
        border-left: solid white 1px;
        padding-left: 5px;
        color: #ffffff;
    }

    .el-upload__input {
        display: none !important;
    }

    .el-upload-list__item-name {
        background-color: transparent !important;
    }

    .font-icon {
        font-size: 20px;
        color: #1b6d85;
    }
</style>