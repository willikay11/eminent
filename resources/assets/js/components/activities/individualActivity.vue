    <template>
        <div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" style="background-color: white">
                <el-tabs v-model="activeName" style="min-height: 500px">
                    <el-tab-pane label="Overview" name="first">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span><strong>Activity: </strong>{{ activityData.name }}</span>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span><strong>Description: </strong>{{ activityData.description }}</span>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span><strong>Status: </strong>{{ activityData.activity_status }}</span>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span><strong>Due Date: </strong>{{ activityData.due_date }}</span>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span><strong>Priority: </strong>{{ activityData.priority_type }}</span>
                            </div>
                        </div>
                    </el-tab-pane>
                    <el-tab-pane label="Comments" name="second">

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

                        <el-input placeholder="Please input" v-model="input">
                            <el-button slot="prepend" v-popover:popover1>Attach</el-button>
                            <el-button @click="postComment" slot="append">Post</el-button>
                        </el-input>

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

                            <div class="form-item-container" v-for="progressUpdate in progressUpdateData">
                                <el-card class="box-card" style="margin-bottom: 20px">
                                    <p>{{ progressUpdate.name }}</p>
                                    <p>{{ progressUpdate.description }}</p>
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
                        </div>
                    </el-tab-pane>
                    <el-tab-pane label="Task" name="fourth">Task</el-tab-pane>
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
                                {{ watcher.initials }}
                            </span>
                        </el-tooltip>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <hr>
                        <div v-if="activityData.isWatcher">
                            <el-button @click="toggleWatcher()">Stop watching</el-button>
                        </div>

                        <div v-if="!activityData.isWatcher">
                            <el-button @click="toggleWatcher()">Start watching</el-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <script>
        export default {
            props: ['activityId'],
            data() {
                // Show a bar for today's date
                const barDate = new Date();
                return {
                    activityStartDate: '',
                    activeName: 'first',
                    activityData: [],
                    commentsData: [],
                    progressUpdateData: [],
                    progressUpdateStatuses:[],
                    watchersData:[],
                    file: false,
                    progressFile: false,
                    input: '',
                    updateTaskProgressDialogVisible: false,
                    data: {
                        comment: '',
                        activity_id: ''
                    },
                    progressData: {
                        description: '',
                        status: '',
                        percentage: '',
                        activity_id: ''
                    },
                    progressRules: {
                        description: [
                            {required: true, message: 'Please input progress description', trigger: 'blur'},
                        ],
                        percentage: [
                            {required: true, message: 'Please input progress percentage', trigger: 'blur', type: 'number'},
                        ],
                        status: [
                            {required: false, message: 'Please select progress status', trigger: 'change', type: 'number'},
                        ],
                    },
                    progressRuleForm: {
                        description: '',
                        status: '',
                        percentage: '',
                    },
                    selectedDate: null,
                    themeStyles: {
                        wrapper: {
                            color: '#fafafa',
                            border: '0',
                            padding: '10px',
                            background: '#454f5f',
                            width: '100%',
                        },
                        header: {
                            padding: '15px 10px 25px 10px',
                        },
                        headerTitle: {
                            fontSize: '1.4rem',
                            fontWeight: '300',
                        },
                        headerArrows: {
                            fontSize: '2rem',
                            fontWeight: '100',
                        },
                        headerHorizontalDivider: {
                            borderTop: 'solid rgba(255, 255, 255, 0.2) 1px',
                            width: '80%',
                        },
                        weekdays: {
                            color: '#2ecdba',
                            fontWeight: '600',
                            padding: '20px 5px 10px 5px',
                        },
                    },
                    attributes: [
                        {
                            highlight: {
                                backgroundColor: '#2ecdba',
                                height: '38px',
                            },
                            dates: {},
                        },
                        {
                            bar: {
                                backgroundColor: '#fafafa',
                            },
                            dates: barDate,
                        },
                    ],
                    themeArr: ['theme1', 'theme2', 'theme3', 'theme4', 'theme5'],
                    selectedTheme: '',
                    selectedIndex: ''
                };
            },
            created()
            {
                let vm = this;

                vm.getActivityInfo();
            },

            methods: {
                checkIfFileIsSelected(file)
                {
                    let vm = this;

                    vm.file = true;

                    if (file.response != undefined && file.response.success) {
                        vm.commentsData.push(file.response.uploadedComment);

                        vm.input = '';
                    }

                },

                checkIfProgressFileIsSelected(file, fileList)
                {
                    let vm = this;

                    if (fileList.length >1)
                    {
                        vm.progressFile = false;

                        vm.$message({
                            type: 'error',
                            message: 'You cannot upload multiple files'
                        });

                        fileList.pop();
                    }else
                    {
                        vm.progressFile = true;
                    }

                },

                removeFileSelected()
                {
                    let vm = this;

                    vm.file = false;
                },

                removeProgressFileSelected()
                {
                    let vm = this;

                    vm.progressFile = false;
                },

                showAddTaskProgress()
                {
                    let vm = this;

                    vm.updateTaskProgressDialogVisible = true;
                },

                getActivityInfo()
                {
                    let vm = this;
                    axios.get('/api/activity/'+vm.activityId)
                        .then(function (response) {
                            vm.attributes[1].dates = response.data.activity.today
                            vm.attributes[0].dates.start = response.data.activity.start_date
                            vm.attributes[0].dates.end = response.data.activity.calendar_end_date
                            vm.activityData = response.data.activity;
                            vm.commentsData = response.data.comments;
                            vm.progressUpdateData = response.data.progressUpdate;
                            vm.progressUpdateStatuses = response.data.progressUpdateStatuses;
                            vm.watchersData = response.data.watchers;
                            console.log(response.data);
                        }).catch(function (error) {
                        console.log(error);
                    });
                },
                postComment()
                {
                    let vm = this;

                    if (vm.file) {

                        vm.data.comment = vm.input;

                        vm.data.activity_id = vm.activityId;

                        vm.$refs.upload.submit();
                    }
                    else {
                        axios.post('/activity/comment', {
                            activity_id: vm.activityId,
                            comment: vm.input
                        })
                            .then(function (response) {

                                vm.input = '';

                                vm.commentsData.push(response.data.uploadedComment);

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

                addProgressUpdate(formName)
                {
                    this.$refs[formName].validate((valid) => {
                        if (valid) {
                            let vm = this;

                            if (vm.progressFile) {

                                vm.progressData.activity_id = vm.activityId;

                                vm.progressData.description = vm.progressRuleForm.description;

                                vm.progressData.status = vm.progressRuleForm.status;

                                vm.progressData.percentage = vm.progressRuleForm.percentage;

                                vm.$refs.progressUpload.submit();

                                vm.$refs[formName].resetFields();

                                vm.getTaskProgressUpdate();

                                vm.updateTaskProgressDialogVisible = false;
                            }
                            else {
                                axios.post('/activity/progress/update', {
                                    activity_id : vm.activityId,
                                    description : vm.progressRuleForm.description,
                                    status : vm.progressRuleForm.status,
                                    percentage : vm.progressRuleForm.percentage,
                                })
                                    .then(function (response) {

                                        vm.progressFile = false;

                                        if (response.data.success) {

                                            vm.$message({
                                                type: 'success',
                                                message: response.data.message
                                            });

                                            vm.getTaskProgressUpdate();

                                            vm.updateTaskProgressDialogVisible = false;

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
                            }
                        } else {
                            return false;
                        }
                    });

                },

                getTaskProgressUpdate()
                {
                    let vm = this;

                    vm.progressUpdateData = [];

                    axios.get('/api/progress/update/'+vm.activityId)
                        .then(function (response) {
                            vm.progressUpdateData = response.data.progressUpdates;
                        }).catch(function (error) {
                        console.log(error);
                    });
                },

                changeColor() {
                    let randIndex;
                    do {
                        randIndex = Math.floor(Math.random() * this.themeArr.length);
                    } while(randIndex === this.selectedIndex);

                    return randIndex;
                },

                toggleWatcher()
                {
                    let vm = this;

                    axios.post('/activity/watch', {
                        activity_id: vm.activityId,
                        watch: !vm.activityData.isWatcher
                    })
                        .then(function (response) {

                            vm.loadWatchers();

                            if (response.data.success) {
                                vm.activityData.isWatcher = !vm.activityData.isWatcher;
                                vm.$message({
                                    type: 'success',
                                    message: response.data.message
                                });
                            }
                            else {
                                vm.activityData.isWatcher = !vm.activityData.isWatcher;
                                vm.$message({
                                    type: 'error',
                                    message: response.data.message
                                });
                            }
                        }).catch(function (error) {
                        console.log(error);
                    });
                },

                loadWatchers()
                {
                    let vm = this;

                    axios.get('/api/watchers/'+vm.activityId)
                        .then(function (response) {
                            vm.watchersData = response.data;
                        }).catch(function (error) {
                        console.log(error);
                    });
                }
            }
        };
    </script>

    <style>
        .el-select {
            width: 100%;
        }

        .el-date-editor.el-input {
            width: 100%;
        }

        .el-input-number{
            width: 100%;
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

        .el-badge__content.is-fixed {
            top: 10px;
            right: 18px;
            position: absolute;
            transform: translateY(-50%) translateX(100%);
        }

        .container {
            width: 50px;
            height: 50px;
            border-radius: 100px;
            background: #333;
        }

        .name {
            width: 100%;
            text-align: center;
            color: white;
            font-size: 18px;
            line-height: 50px;
        }

        .theme1 {
            background-color: #AA3323;
        }

        .theme2 {
            background-color: #F29A2E;
        }

        .theme3 {
            background-color: #385273;
        }

        .theme4 {
            background-color: #36B1BF;
        }

        .theme5 {
            background-color: #5A0011;
        }
    </style>