<template>
    <!-- Fixed navbar -->
    <div>
        <div id="fixedNav" class="navbar navbar-fixed-top active" role="navigation">
            <div class="navbar-header">
                <div class="navbar-left show-hamburger">
                    <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                        <i class="glyphicon glyphicon-align-left"></i>
                        <span></span>
                    </button>
                </div>
            </div>

            <div class="navbar-right" style="margin-right: 40px">
                <el-popover
                        ref="popover2"
                        placement="bottom"
                        width="150"
                        trigger="hover">
                    <ul class="profile-dropdown">
                        <li><a @click="showFeedbackDialog">Feedback</a> &nbsp;<i class="fa fa-comments-o" aria-hidden="true"></i></li>
                        <li><a @click="logout">Logout</a> &nbsp;<i class="glyphicon glyphicon-log-in"></i></li>
                    </ul>
                </el-popover>
                <span class="username" v-popover:popover2>{{ userName }}</span>
            </div>
        </div>

        <el-dialog
                title="Give Feedback"
                :visible.sync="feedbackDialog"
                size="small">
            <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-position="left">

                <div class="form-item-container">
                    <el-row :span="24" :gutter="20">
                        <el-col :span="4">
                            <span>Subject: </span>
                        </el-col>
                        <el-col :span="20">
                            <el-form-item prop="name">
                                <el-input placeholder="Subject" v-model="ruleForm.subject"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>

                    <el-row :span="24" :gutter="20">
                        <el-col :span="4">
                            <span>Message: </span>
                        </el-col>
                        <el-col :span="20">
                            <el-form-item prop="message">
                                <el-input placeholder="Message"
                                          type="textarea"
                                          :rows="3"
                                          v-model="ruleForm.message"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                </div>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button @click="feedbackDialog = false">Cancel</el-button>
                    <el-button type="primary" @click="postFeedback('ruleForm')">Post</el-button>
                </span>
        </el-dialog>
    </div>
</template>

<script>
    export default {
        props: ['userName'],
        data()
        {
            return{
                feedbackDialog: false,
                ruleForm:{
                    subject: '',
                    message: '',
                },
                rules: {
                    subject: [
                        {required: true, message: 'Please input subject', trigger: 'blur'},
                    ],
                    message: [
                        {required: true, message: 'Please input message', trigger: 'blur'},
                    ],
                },
            }
        },
        methods:{
            logout()
            {
                window.location.href = '/logout'
            },
            showFeedbackDialog()
            {
                let vm = this;

                vm.feedbackDialog = true;
            },
            postFeedback(formName)
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
                            message: 'Posting feedback'
                        });

                        axios.post('/post/feedback', {
                            subject: vm.ruleForm.subject,
                            message: vm.ruleForm.message,
                        })
                            .then(function (response) {

                                if (response.data.success) {
                                    vm.feedbackDialog = false;

                                    vm.$message({
                                        type: 'success',
                                        message: response.data.message
                                    });

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