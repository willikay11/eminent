@extends('dashboard.default')


@section('main-content')

    <section class="content-header">
        <h1>
            Contacts Details
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/contacts"><i class="fa fa-address-card"></i> Contacts</a></li>
            <li class="active">Details</li>
        </ol>
    </section>

    <section class="content">
        <contact-details :user-client-id="{!! $id !!}" inline-template>
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <div class="pull-left">
                                <h3 class="box-title">Details</h3>
                            </div>
                        </div>

                        <el-row :gutter="20" style="padding-right: 10px; padding-left: 10px">
                            <el-col :xs="6" :sm="6" :md="6" :lg="6">
                                <div class="avatar"></div>
                            </el-col>
                            <el-col :xs="18" :sm="18" :md="18" :lg="18">
                                <el-col :span="24">
                                    <h4>@{{ contact.name }}</h4>
                                </el-col>

                                <el-col :span="24" class="contact-row">
                                    <span>Contact assigned to @{{ contact.user }}</span>
                                </el-col>

                                <el-col :span="24" class="contact-row">
                                    <span>Email : </span><a href="#" class="span-holder ebg-anchor"> &nbsp; @{{ contact.email }} - Send Email</a>
                                </el-col>

                                <el-col :span="24" class="contact-row">
                                    <span>Phone Number :</span><a href="#" class="span-holder"> &nbsp; @{{ contact.phone }}</a>
                                </el-col>

                                <el-col class="contact-row" v-if="contact.interactionDate == null">
                                    <span>Next Interaction Date :</span>
                                    <a href="#" @click="showInteraction()" class="span-holder ebg-anchor"> Not Scheduled - Schedule Interaction</a>
                                </el-col>

                                <el-col :span="24" class="contact-row" v-if="contact.interactionDate != null">
                                    <span>Next Interaction Date :</span>
                                    <a href="#" @click="showInteraction()" class="span-holder ebg-anchor"> &nbsp; @{{ contact.interactionDate }} - Edit Scheduled Interaction</a>
                                </el-col>

                                <el-row :gutter="20">
                                    <el-col :span="24" class="contact-row">
                                        <el-col :xs="16" :sm="12" :md="12" :lg="6">
                                            <el-select v-model="statusValue" placeholder="Select" @change="changeStatus">
                                            <el-option
                                                    v-for="item in statuses"
                                                    :key="item.value"
                                                    :label="item.label"
                                                    :value="item.value">
                                            </el-option>
                                            </el-select>
                                        </el-col>

                                        <el-col :span="6">
                                            <el-button type="primary" icon="el-icon-plus" v-on:click="showClientNoteDialog()">Add Client Note</el-button>
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

                                    <el-col :xs="24" :sm="24" :md="8" :lg="8">
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

                                    <el-col :xs="24" :sm="24" :md="8" :lg="8">
                                        <el-form-item prop="interactionDate" label="When was the interaction?">
                                            <el-date-picker
                                                    v-model="ruleForm.interactionDate"
                                                    type="date"
                                                    placeholder="Select the interaction date">
                                            </el-date-picker>
                                        </el-form-item>
                                    </el-col>

                                    <el-col :xs="24" :sm="24" :md="8" :lg="8">
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

                                    <el-col :span="6">
                                        <el-button size="" type="primary" icon="el-icon-plus" @click="addInteraction('ruleForm')">Save this Interaction</el-button>
                                    </el-col>
                                </el-row>
                            </el-form>

                        </el-row>

                        <el-row :span="24" style="margin-top: 20px; margin-left: 10px; margin-right: 10px;">
                            <el-tabs v-model="activeName">
                                <el-tab-pane label="Interactions" name="first">
                                    <ul style="list-style: none; padding-left:0px" v-for="interaction in interactionData">
                                        <li>
                                            <div class="col-lg-8 col-md-8 col-sm-12">
                                                <span>@{{ interaction.remarks }}</span>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12" style="text-align: right">
                                                <span> <i class="fa fa-clock-o" aria-hidden="true"></i> &nbsp; @{{ interaction.date }}</span> &nbsp; &nbsp;
                                                <span> <i class="fa fa-user" aria-hidden="true"></i> &nbsp; @{{ interaction.user }}</span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <span v-if="interaction.interactionTypeId == 1"> <i class="fa fa-meetup" aria-hidden="true"></i> &nbsp; Interacted over @{{ interaction.interactionType }}</span>
                                                <span v-if="interaction.interactionTypeId == 2"> <i class="fa fa-phone" aria-hidden="true"></i> &nbsp; Interacted over @{{ interaction.interactionType }}</span>
                                                <span v-if="interaction.interactionTypeId == 3"> <i class="fa fa-envelope-o" aria-hidden="true"></i> &nbsp; Interacted over @{{ interaction.interactionType }}</span>
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
                                            <div class="col-lg-8 col-md-8 col-sm-12">
                                                <span>@{{ note.note }}</span>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12" style="text-align: right">
                                                <span> <i class="fa fa-clock-o" aria-hidden="true"></i> &nbsp; @{{ note.date }}</span> &nbsp; &nbsp;
                                                <span> <i class="fa fa-clock-o" aria-hidden="true"></i> &nbsp; @{{ note.user }}</span>
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
        </contact-details>
    </section>
    {{--<div class="row">--}}
        {{--<div class="col-lg-12">--}}
            {{--<contact-details :user-client-id="{!! $id !!}"></contact-details>--}}
        {{--</div>--}}
    {{--</div>--}}

@stop