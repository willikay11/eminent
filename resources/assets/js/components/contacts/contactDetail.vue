<template>
    <div class="panel panel-default">
        <div class="col-lg-12 panel-header">
            <div class="col-lg-6">
                <h4>Contacts</h4>
            </div>
            <div class="col-lg-6" style="text-align: right">
                <!--<button class="btn ebg-button" v-on:click="showAddDialog()">Add Contact</button>-->
            </div>
        </div>

        <div class="panel-body">

            <hr class="panel-hr">

            <div class="contact-container">

                <el-row>
                    <el-col :span="5">
                        <div class="avatar"></div>
                    </el-col>
                    <el-col :span="19">
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

                        <el-col :span="24" class="contact-row" v-if="contact.interactionDate == null">
                            <span>Next Interaction Date :</span>
                            <a href="#" class="span-holder ebg-anchor"> &nbsp; Not Scheduled - Schedule Interaction</a>
                        </el-col>

                        <el-col :span="24" class="contact-row" v-if="contact.interactionDate != null">
                            <span>Next Interaction Date :</span>
                            <a href="#" class="span-holder ebg-anchor"> &nbsp; {{ contact.interactionDate }} - Edit Scheduled Interaction</a>
                        </el-col>

                        <el-row :gutter="20">
                            <el-col :span="24" class="contact-row">
                                <el-col :span="5">
                                    <el-select v-model="statusValue" placeholder="Select">
                                        <el-option
                                                v-for="item in statuses"
                                                :key="item.value"
                                                :label="item.label"
                                                :value="item.value">
                                        </el-option>
                                    </el-select>
                                </el-col>
                                <el-col :span="6">
                                    <button class="btn ebg-button" v-on:click="showAddDialog()">Add Product Feedback</button>
                                </el-col>

                                <el-col :span="6">
                                    <button class="btn ebg-button" v-on:click="showAddDialog()">Add Client Note</button>
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
                                                v-for="item in options"
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
                                <button class="btn ebg-button" v-on:click="showAddDialog()">Save this Interaction</button>
                            </el-col>
                        </el-row>
                    </el-form>


                </el-row>
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
                value: '',
                statusValue: '',
                textarea: '',
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
                        {required: true, message: 'Please select interaction type', trigger: 'change'},
                    ],
                    interactionDate: [
                        {required: true, message: 'Please input interaction date', trigger: 'blur', type: 'date'},
                    ],
                    nextInteractionDate: [
                        {required: false, message: 'Please input interaction date', trigger: 'blur', type: 'date'},
                    ],
                }
            }
        },
        created()
        {
            let vm = this;

            vm.getContactInfo();

        },
        methods:{
            getContactInfo()
            {
                let vm = this;
                axios.get('/api/contact/details/'+vm.userClientId)
                    .then(function (response) {
                        vm.statuses = response.data.statuses;
                        vm.contact = response.data.contact;
                        vm.statusValue = vm.contact.status;
                    }).catch(function (error) {
                    console.log(error);
                })
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
    }
</style>