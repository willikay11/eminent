<template>
    <div class="panel panel-default">
        <div class="col-lg-12 panel-header">
            <div class="col-lg-6">
                <h4>Contacts</h4>
            </div>
        </div>

        <div class="panel-body">

            <hr class="panel-hr">

            <div class="contact-container">

                <el-row :gutter="20">
                    <el-col :xs="6" :sm="6" :md="6" :lg="6">
                        <div class="avatar"></div>
                    </el-col>
                    <el-col :xs="18" :sm="18" :md="18" :lg="18">
                        <el-col :span="24">
                            <h4>{{ contact.name }}</h4>
                        </el-col>

                        <el-col :span="24" class="contact-row">
                            <span>Contact assigned to {{ contact.user }}</span>
                        </el-col>

                        <el-col :span="24" class="contact-row">
                            <span>Email : </span><a href="#" class="span-holder ebg-anchor"> &nbsp; {{ contact.email }} - Send Email</a>
                        </el-col>

                        <el-col :span="24" class="contact-row">
                            <span>Phone Number :</span><a href="#" class="span-holder"> &nbsp; {{ contact.phone }}</a>
                        </el-col>

                        <el-col class="contact-row" v-if="contact.interactionDate == null">
                            <span>Next Interaction Date :</span>
                            <a href="#" @click="showInteraction()" class="span-holder ebg-anchor"> Not Scheduled - Schedule Interaction</a>
                        </el-col>

                        <el-col :span="24" class="contact-row" v-if="contact.interactionDate != null">
                            <span>Next Interaction Date :</span>
                            <a href="#" @click="showInteraction()" class="span-holder ebg-anchor"> &nbsp; {{ contact.interactionDate }} - Edit Scheduled Interaction</a>
                        </el-col>

                        <el-row :gutter="20">
                            <el-col :span="24" class="contact-row">
                                <el-col :span="5">
                                    <el-select v-model="statusValue" placeholder="Select">
                                        <el-option
                                                v-for="item in statuses"
                                                :key="item.value"
                                                :label="item.label"
                                                :value="item.value"
                                                change="changeStatus()">
                                        </el-option>
                                    </el-select>
                                </el-col>

                                <el-col :span="6">
                                    <button class="btn ebg-button" v-on:click="showClientNoteDialog()">Add Client Note</button>
                                </el-col>
                            </el-col>
                        </el-row>

                    </el-col>
                </el-row>

                <el-row :span="24">
                    <div class="col-lg-12">
                        <hr>
                    </div>
                </el-row>

                <el-row :span="24" class="interaction-container">
                    <el-col :span="24">
                        <p class="input-label">Add Interaction</p>
                        <hr class="interaction-hr">
                    </el-col>

                    <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-position="top">
                        <el-row :span="24" :gutter="20">
                            <el-col :span="24">
                                <el-form-item prop="interactionRemarks">
                                    <el-input
                                            type="textarea"
                                            :rows="5"
                                            placeholder="Interaction Remarks"
                                            v-model="ruleForm.interactionRemarks">
                                    </el-input>
                                </el-form-item>
                            </el-col>

                            <el-col :span="8">
                                <el-form-item prop="interaction" label="How did you interact?">
                                    <el-select v-model="ruleForm.interaction" placeholder="Select the type of interaction">
                                        <el-option
                                                v-for="item in interactionTypes"
                                                :key="item.value"
                                                :label="item.label"
                                                :value="item.value">
                                        </el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>

                            <el-col :span="8">
                                <el-form-item prop="interactionDate" label="When was the interaction?">
                                    <el-date-picker
                                            v-model="ruleForm.interactionDate"
                                            type="date"
                                            placeholder="Select the interaction date">
                                    </el-date-picker>
                                </el-form-item>
                            </el-col>

                            <el-col :span="8">
                                <el-form-item prop="nextInteractionDate" label="Add next interaction?">
                                    <el-date-picker
                                            v-model="ruleForm.nextInteractionDate"
                                            type="date"
                                            placeholder="Schedule a date for the next interaction">
                                    </el-date-picker>
                                </el-form-item>
                            </el-col>

                            <el-col :span="24">
                                <hr class="interaction-hr">
                            </el-col>

                            <el-col :span="24">
                                <el-form-item prop="feedback" label="Did the client provide any feeedback?">
                                    <el-input
                                            type="textarea"
                                            :rows="5"
                                            placeholder="Enter the feedback remarks"
                                            v-model="ruleForm.feedback">
                                    </el-input>
                                </el-form-item>
                            </el-col>

                            <el-col :span="24">
                                <hr class="interaction-hr">
                            </el-col>

                            <el-col :span="6">
                                <button class="btn ebg-button" @click="addInteraction('ruleForm')">Save this Interaction</button>
                            </el-col>
                        </el-row>
                    </el-form>

                </el-row>

                <el-row :span="24" style="margin-top: 20px">
                    <el-tabs v-model="activeName">
                        <el-tab-pane label="Interactions" name="first">
                            <ul style="list-style: none; padding-left:0px" v-for="interaction in interactionData">
                                <li>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <span>{{ interaction.remarks }}</span>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12" style="text-align: right">
                                        <span> <i class="fa fa-clock-o" aria-hidden="true"></i> &nbsp; {{ interaction.date }}</span>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <span v-if="interaction.interactionTypeId == 1"> <i class="fa fa-meetup" aria-hidden="true"></i> &nbsp; Interacted over {{ interaction.interactionType }}</span>
                                        <span v-if="interaction.interactionTypeId == 2"> <i class="fa fa-phone" aria-hidden="true"></i> &nbsp; Interacted over {{ interaction.interactionType }}</span>
                                        <span v-if="interaction.interactionTypeId == 3"> <i class="fa fa-envelope-o" aria-hidden="true"></i> &nbsp; Interacted over {{ interaction.interactionType }}</span>
                                    </div>
                                    <div class="col-lg-12">
                                        <hr>
                                    </div>
                                </li>
                            </ul>
                            <span v-if="interactionData.length == 0">No interactions recorded</span>
                        </el-tab-pane>
                        <el-tab-pane label="Notes" name="second">
                            <ul v-if="noteData.length > 0" style="list-style: none; padding-left:0px" v-for="note in noteData">
                                <li>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <span>{{ note.note }}</span>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12" style="text-align: right">
                                        <span> <i class="fa fa-clock-o" aria-hidden="true"></i> &nbsp; {{ note.date }}</span>
                                    </div>
                                    <div class="col-lg-12">
                                        <hr>
                                    </div>
                                </li>
                            </ul>
                            <span v-if="noteData.length == 0">No notes recorded</span>
                        </el-tab-pane>
                    </el-tabs>
                </el-row>

                <el-dialog
                        title="Schedule Interaction for Client"
                        :visible.sync="interactionDialogVisible"
                        size="tiny">
                    <el-form :model="scheduleForm" :rules="scheduleRules" ref="scheduleForm" label-position="top">
                        <el-form-item prop="nextInteractionDate" label="Add next interaction">
                            <el-date-picker
                                    v-model="scheduleForm.nextInteractionDate"
                                    type="datetime"
                                    format="yyyy-MM-dd:HH:mm"
                                    placeholder="Schedule a date for the next interaction">
                            </el-date-picker>
                        </el-form-item>
                    </el-form>
                    <span slot="footer" class="dialog-footer">
                        <el-button @click="interactionDialogVisible = false">Cancel</el-button>
                        <el-button type="primary"  @click="addInteractionSchedule('scheduleForm')">Save</el-button>
                    </span>
                </el-dialog>

                <el-dialog
                        title="Add Client Note"
                        :visible.sync="clientNoteDialogVisible"
                        size="tiny">
                    <el-form :model="noteForm" :rules="noteRules" ref="noteForm" label-position="top">
                        <el-form-item prop="note" label="Enter a note about the client e.g. enjoys playing golf">
                            <el-input
                                    type="textarea"
                                    :rows="5"
                                    placeholder="Enter the feedback remarks"
                                    v-model="noteForm.note">
                            </el-input>
                        </el-form-item>
                    </el-form>
                    <span slot="footer" class="dialog-footer">
                        <el-button @click="clientNoteDialogVisible = false">Cancel</el-button>
                        <el-button type="primary"  @click="addClientNote('noteForm')">Save</el-button>
                    </span>
                </el-dialog>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['userClientId'],
        data() {
            return {
                contact: [],
                statuses: [],
                interactionTypes: [],
                interactionData: [],
                noteData: [],
                options: [{
                    value: 'Option1',
                    label: 'Option1'
                }, {
                    value: 'Option2',
                    label: 'Option2'
                }, {
                    value: 'Option3',
                    label: 'Option3'
                }, {
                    value: 'Option4',
                    label: 'Option4'
                }, {
                    value: 'Option5',
                    label: 'Option5'
                }],
                interactionDialogVisible: false,
                clientNoteDialogVisible: false,
                value: '',
                statusValue: '',
                textarea: '',
                scheduleForm: {
                    nextInteractionDate: ''
                },
                scheduleRules: {
                    nextInteractionDate: [
                        {required: true, message: 'Please input next interaction date', trigger: 'blur', type: 'date'},
                    ],
                },
                noteForm: {
                    note: ''
                },
                noteRules: {
                    note: [
                        {required: true, message: 'Please input next client note', trigger: 'blur'},
                    ],
                },
                ruleForm: {
                    interactionRemarks: '',
                    feedback: '',
                    interaction: '',
                    interactionDate: '',
                    nextInteractionDate: '',
                },
                rules: {
                    interactionRemarks: [
                        {required: true, message: 'Please input interaction remarks', trigger: 'blur'},
                    ],
                    feedback: [
                        {required: false, message: 'Please input interaction remarks', trigger: 'blur'},
                    ],
                    interaction: [
                        {required: true, message: 'Please select interaction type', trigger: 'change', type: 'number'},
                    ],
                    interactionDate: [
                        {required: true, message: 'Please input interaction date', trigger: 'blur', type: 'date'},
                    ],
                    nextInteractionDate: [
                        {required: false, message: 'Please input interaction date', trigger: 'blur', type: 'date'},
                    ],
                },
                activeName: 'first'
            }
        },
        created()
        {
            let vm = this;

            vm.getContactInfo();

        },
        methods:{
            addClientNote(formName)
            {
                this.$refs[formName].validate((valid) => {
                if (valid) {

                    let vm = this;

                    vm.$message({
                        type: 'info',
                        message: 'Saving client Note'
                    });

                    axios.post('/notes/save', {
                        note: vm.noteForm.note,
                        userClientId: vm.userClientId
                    })
                        .then(function (response) {
                            vm.clientNoteDialogVisible = false;

                            if (response.data.success) {
                                vm.$message({
                                    type: 'success',
                                    message: response.data.message
                                });

                                vm.getContactInfo();

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

            addInteractionSchedule(formName)
            {
                this.$refs[formName].validate((valid) => {
                    if (valid) {

                        let vm = this;

                        vm.$message({
                            type: 'info',
                            message: 'Saving Interaction Schedule'
                        });

                        axios.post('/interactionSchedule/save', {
                            next_interaction_date: vm.scheduleForm.nextInteractionDate+'',
                            userClientId: vm.userClientId
                        })
                            .then(function (response) {
                                vm.interactionDialogVisible = false;

                                if (response.data.success) {
                                    vm.$message({
                                        type: 'success',
                                        message: response.data.message
                                    });

                                    vm.contact.interactionDate = response.data.schedule;
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

            addInteraction(formName)
            {
//                this.$refs[formName].validate((valid) => {
//                    if (valid) {
//
//                        let vm = this;
//
//                        vm.$message({
//                            type: 'info',
//                            message: 'Saving Interaction'
//                        });
//
//                        axios.post('/interaction/save', {
//                            remarks: vm.ruleForm.interactionRemarks,
//                            interaction_type_id: vm.ruleForm.interaction,
//                            interaction_date: vm.ruleForm.interactionDate+'',
//                            next_interaction_date: vm.ruleForm.nextInteractionDate+'',
//                            userClientId: vm.userClientId
//                        })
//                            .then(function (response) {
//                                if (response.data.success) {
//                                    vm.$message({
//                                        type: 'success',
//                                        message: response.data.message
//                                    });
//
//                                    vm.$refs[formName].resetFields();
//                                }
//                                else {
//                                    vm.$message({
//                                        type: 'error',
//                                        message: response.data.message
//                                    });
//                                }
//                            }).catch(function (error) {
//                            console.log(error);
//                        });
//                    } else {
//                        return false;
//                    }
//                });
            },

            getContactInfo()
            {
                let vm = this;
                axios.get('/api/contact/details/'+vm.userClientId)
                    .then(function (response) {
                        vm.statuses = response.data.statuses;
                        vm.interactionTypes = response.data.interactionTypes;
                        vm.contact = response.data.contact;
                        vm.statusValue = vm.contact.status;
                        vm.interactionData = response.data.interactions;
                        vm.noteData = response.data.notes;
                    }).catch(function (error) {
                    console.log(error);
                })
            },
            showInteraction()
            {
              let vm = this;

              vm.interactionDialogVisible = true;
            },

            showClientNoteDialog()
            {
              let vm = this;

              vm.clientNoteDialogVisible = true;
            },
            changeStatus()
            {
                console.log("Changing");
            }
        }
    }

</script>

<style>
    .contact-container{
        margin-left: 20px;
        margin-right: 20px;
    }
    .avatar{
        margin-right: 40px;
        height: 250px;
        max-width: 250px;
        min-width: 250px;
        background: #f2f2f2;
        border: 1px solid #b5b5b5;
    }
    .span-holder{
        display: inline-block;
    }
    .contact-row{
        margin-top: 10px;
    }
    .interaction-container{
        background-color: #f3f3f3;
        padding: 15px;
    }

    .interaction-hr{
        border-top: 1px solid #b0b0b0;
        margin-top: 10px;
    }
    .input-label{
        color: #4a4a4a;
    }

    .el-select{
        width: 100%;
    }

    .el-date-editor.el-input {
        width: 100%;
    }

    label{
        font-weight: normal;
    }

    .ebg-anchor{
        color: #eaa568;
        z-index: 1;
        position: relative;
    }
</style>