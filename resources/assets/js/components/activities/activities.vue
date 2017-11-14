<template>
    <div>
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
                                <div><span v-if="element.priority_type == 'Low'" class="low-priority-span">Low Priority</span></div>
                                <div><span v-if="element.priority_type == 'Medium'" class="med-priority-span">Med Priority</span></div>
                                <div><span v-if="element.priority_type == 'High'" class="high-priority-span">High Priority</span></div>
                                <div class="element-container">{{ element.name }}</div>
                            </div>
                        </draggable>
                    </div>
                    <div class="panel-footer">
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
                                <div><span v-if="element.priority_type == 'Low'" class="low-priority-span">Low Priority</span></div>
                                <div><span v-if="element.priority_type == 'Medium'" class="med-priority-span">Med Priority</span></div>
                                <div><span v-if="element.priority_type == 'High'" class="high-priority-span">High Priority</span></div>
                                <div class="element-container">{{ element.name }}</div>
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
                                <div><span v-if="element.priority_type == 'Low'" class="low-priority-span">Low Priority</span></div>
                                <div><span v-if="element.priority_type == 'Medium'" class="med-priority-span">Med Priority</span></div>
                                <div><span v-if="element.priority_type == 'High'" class="high-priority-span">High Priority</span></div>
                                <div class="element-container">{{ element.name }}</div>
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
                                <div><span v-if="element.priority_type == 'Low'" class="low-priority-span">Low Priority</span></div>
                                <div><span v-if="element.priority_type == 'Medium'" class="med-priority-span">Med Priority</span></div>
                                <div><span v-if="element.priority_type == 'High'" class="high-priority-span">High Priority</span></div>
                                <div class="element-container">{{ element.name }}</div>
                            </div>
                        </draggable>
                    </div>
                </div>
            </el-col>
        </el-row>

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
    </div>


</template>

<script>

    import draggable from 'vuedraggable';

    export default{
        components: {draggable},
        props: [],
        data (){
            return {
                todo: [],
                inProgress: [],
                inReview: [],
                done: [],
                taskDialogVisible: false,
                activity_status_id: '',
                targetElementName: '',
                draggedElement: '',
                from: '',
                to: '',
                users:[],
                priorityTypes:[],
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
            showMove(evt, originalEvent){
                let vm  = this;

                vm.draggedElement = evt.draggedContext;

                vm.from = evt.from.id;

                vm.to = evt.to.id;
            },
            onEnd(evt){
                let vm = this;

                if(vm.from != vm.to)
                {
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
                        vm.todo = (response.data.todo == undefined)?[]:response.data.todo;
                        vm.inProgress = (response.data.progress == undefined)?[]:response.data.progress;
                        vm.inReview = (response.data.review == undefined)?[]:response.data.review;
                        vm.done = (response.data.done == undefined)?[]:response.data.done;
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
                            due_date: vm.ruleForm.dueDate+'',
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
            }
        }
    }
</script>

<style>
    .el-select{
        width: 100%;
    }

    .el-date-editor.el-input{
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
</style>