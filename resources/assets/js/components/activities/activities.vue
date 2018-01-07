<template>
</template>

<script>

    import draggable from 'vuedraggable';

    import moment from 'moment';

    export default{
        components: {draggable},
        props: ['userId'],
        data (){
            return {
                file: false,
                progressFile: false,
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
                input: '',
                selectedTask: {
                    'comments': []
                },
                loading: true,
                selectedProgressUpdateFiles : '',
                todo: [],
                inProgress: [],
                inReview: [],
                done: [],
                progressUpdateData: [],
                progressUpdateStatuses:[],
                taskDialogVisible: false,
                watchTaskDialogVisible: false,
                commentsDialog: false,
                taskProgressDialogVisible: false,
                updateTaskProgressDialogVisible: false,
                taskProgressFileDialogVisible: false,
                activity_status_id: '',
                targetElementName: '',
                draggedElement: '',
                from: '',
                to: '',
                users: [],
                statuses: [],
                priorityTypes: [],
                activityTypes: [],
                userClients: [],
                options: [{
                    value: '1',
                    label: 'Active'
                }, {
                    value: '0',
                    label: 'Inactive'
                }],
                progressRuleForm: {
                    description: '',
                    status: '',
                    percentage: '',
                },
                ruleForm: {
                    name: '',
                    description: '',
                    activityType: '',
                    user: '',
                    priority: '',
                    dueDate: '',
                    projectedRevenue: '',
                },
                searchForm: {
                    startDate: '',
                    endDate: '',
                    user: '',
                    priority: '',
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
                searchRules: {
//                    startDate: [
//                        {required: false, message: 'Please input start date', trigger: 'blur', type: 'date'},
//                    ],
//                    endDate: [
//                        {required: false, message: 'Please input end date', trigger: 'blur', type: 'date'},
//                    ],
//                    user: [
//                        {required: false, message: 'Please select user', trigger: 'change'},
//                    ],
//                    priority: [
//                        {required: false, message: 'Please select status', trigger: 'change'},
//                    ],
                },
                rules: {
                    name: [
                        {required: true, message: 'Please input activity name', trigger: 'blur'},
                    ],
                    projectedRevenue: [
                        {required: false, message: 'Please input projected revenue', trigger: 'blur', type: 'number'},
                    ],
                    description: [
                        {required: true, message: 'Please input activity description', trigger: 'blur'},
                    ],
                    user: [
                        {required: false, message: 'Please select user', trigger: 'change', type: 'number'},
                    ],
                    activityType: [
                        {required: false, message: 'Please select activity type', trigger: 'change', type: 'number'},
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

            removeProgressFileSelected()
            {
                let vm = this;

                vm.progressFile = false;
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

            showMove(evt, originalEvent)
            {
                let vm = this;

                vm.draggedElement = evt.draggedContext;

                vm.from = evt.from.id;

                vm.to = evt.to.id;
            },

            onEnd(evt)
            {
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

                axios.get('/info/activities/')
                    .then(function (response) {
                        vm.users = response.data.users;
                        vm.priorityTypes = response.data.priorities;
                        vm.progressUpdateStatuses = response.data.progressUpdateStatuses;
                        vm.activityTypes = response.data.activityTypes;
                        vm.userClients = response.data.userClients;
                    }).catch(function (error) {
                    console.log(error);
                })
            },

            getActivities()
            {
                let vm = this;
                axios.get('/api/activities/'+vm.userId)
                    .then(function (response) {
                        vm.todo = (response.data.todo == undefined) ? [] : response.data.todo;
                        vm.inProgress = (response.data.progress == undefined) ? [] : response.data.progress;
                        vm.inReview = (response.data.review == undefined) ? [] : response.data.review;
                        vm.done = (response.data.done == undefined) ? [] : response.data.done;
                        vm.loading = false;
                    }).catch(function (error) {
                    console.log(error);
                });
            },

            addTask(formName)
            {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        let vm = this;

                        let user = vm.userId;

                        if(vm.ruleForm.user != '')
                        {
                            user = vm.ruleForm.user
                        }

                        vm.$message({
                            type: 'info',
                            message: 'Saving Task'
                        });

                        axios.post('/activity/save', {
                            activity_id: null,
                            type: 1,
                            name: vm.ruleForm.name,
                            description: vm.ruleForm.description,
                            user_id: user,
                            priority_type_id: vm.ruleForm.priority,
                            due_date: moment(vm.ruleForm.dueDate ).format("YYYY-MM-DD"),
                            activity_status_id: 1,
                            activity_type_id: vm.ruleForm.activityType,
                            projected_revenue: vm.ruleForm.projectedRevenue,
                            user_client_id: vm.ruleForm.source
                        })
                            .then(function (response) {

                                if (response.data.success) {
                                    vm.taskDialogVisible = false;

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

            showTaskProgressFiles(files)
            {
                let vm = this;

                vm.taskProgressFileDialogVisible = true;

                vm.selectedProgressUpdateFiles = files;

            },

            showTaskProgress(task)
            {
                let vm = this;

                vm.taskProgressDialogVisible = true;

                vm.selectedTask = task;

                vm.getTaskProgressUpdate();
            },

            showAddTaskProgress()
            {
                let vm = this;

                vm.updateTaskProgressDialogVisible = true;
            },

            getTaskProgressUpdate()
            {
                let vm = this;

                vm.progressUpdateData = [];

                axios.get('/api/progress/update/'+vm.selectedTask.id)
                    .then(function (response) {
                        vm.progressUpdateData = response.data.progressUpdates;
                    }).catch(function (error) {
                    console.log(error);
                });
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

            addProgressUpdate(formName)
            {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        let vm = this;

                        if (vm.progressFile) {

                            vm.progressData.activity_id = vm.selectedTask.id;

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
                                activity_id : vm.selectedTask.id,
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

                let user = vm.userId;

                let startDate = '';

                let endDate = '';

                vm.loading = true;

                vm.$message({
                    type: 'info',
                    message: 'Searching...'
                });

                if (vm.searchForm.user != '')
                {
                    user = vm.searchForm.user;
                }

                if(vm.searchForm.startDate != '')
                {
                    startDate = moment(vm.searchForm.startDate).format("YYYY-MM-DD");
                }

                if(vm.searchForm.endDate != '')
                {
                    endDate = moment(vm.searchForm.endDate).format("YYYY-MM-DD")
                }

                axios.post('/activity/search', {
                    startDate: startDate,
                    endDate: endDate,
                    priority: vm.searchForm.priority,
                    userId: user,
                })
                    .then(function (response) {

                        vm.loading = false;

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

    .task-progress-update .el-dialog__body{
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

    .el-input-number{
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

    .el-badge__content.is-fixed {
        top: 10px;
        right: 18px;
        position: absolute;
        transform: translateY(-50%) translateX(100%);
    }

    @media(min-width:768px) and (max-width:991px){
        .el-dialog--small {
            width: 90%;
        }
    }

    @media(max-width:767px){
        .el-dialog--small {
            width: 90%;
        }
    }

    @media(min-width:992px) and (max-width:1199px){
        .el-dialog--small {
            width: 70%;
        }
    }
</style>