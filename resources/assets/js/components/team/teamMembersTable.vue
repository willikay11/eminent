<template>
    <div class="panel panel-default">
        <div class="col-lg-12 panel-header">
            <div class="col-lg-6">
                <h4>{{ teamName }}</h4>
            </div>
            <div class="col-lg-6" style="text-align: right">
                <button class="btn ebg-button" v-on:click="showAddTeamMemberDialog()">Add Members</button>
            </div>
        </div>
        <div class="panel-body">
            <el-table
                    :data="tableData"
                    stripe
                    style="width: 100%">
                <el-table-column
                        prop="name"
                        label="Name">
                </el-table-column>
                <el-table-column
                        prop="email"
                        label="Email">
                </el-table-column>
                <el-table-column
                        label="Actions">
                    <template slot-scope="scope">
                        <el-button @click="removeTeamMember(scope.row)" size="small">Remove</el-button>
                        <el-button @click="contacts(scope.row)"size="small">Contacts</el-button>
                        <el-button @click="interactions(scope.row)"size="small">Interactions</el-button>
                        <el-button @click="activities(scope.row)"size="small">Activities</el-button>
                    </template>
                </el-table-column>
            </el-table>
        </div>
        <hr class="panel-hr">
        <div class="panel-footer">
            <div class="block">
                <el-pagination
                        layout="prev, pager, next"
                        :total="total">
                </el-pagination>
            </div>
        </div>

        <el-dialog
                title="Add Team Member"
                :visible.sync="dialogVisible"
                size="tiny">
            <el-form label-position="top">

                <el-form-item prop="teamMembers" label="Team Members">
                    <multiselect
                            v-model="selectedUsers"
                            :options="users"
                            :multiple="true"
                            track-by="value"
                            :custom-label="userName">
                    </multiselect>
                </el-form-item>

            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button @click="dialogVisible = false">Cancel</el-button>
                <el-button type="primary" @click="addTeamMembers">Save</el-button>
            </span>
        </el-dialog>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';

    export default {
        components: {Multiselect},
        props: ['teamId', 'teamName'],
        data() {
            return {
                tableData: [],
                options: [{
                    value: '1',
                    label: 'Active'
                }, {
                    value: '0',
                    label: 'Inactive'
                }],
                users:[],
                selectedUsers:[],
                total: 0,
                dialogVisible: false,
            }
        },
        created: function () {
            let vm = this;

            vm.getTeamMembers();

            vm.getInformation();
        },

        methods:{
            handleClick() {
                console.log('click');
            },

            getInformation()
            {
                let vm = this;
                axios.get('/teams/info')
                    .then(function (response) {
                        vm.users = response.data.users;
                    }).catch(function (error) {
                    console.log(error);
                })
            },
            getTeamMembers()
            {
                let vm = this;
                axios.get('/api/team/'+vm.teamId+'/members')
                    .then(function (response) {
                        vm.tableData = [].concat(response.data.data);
                        vm.total = response.data.last_page;
                    }).catch(function (error) {
                    console.log(error);
                })
            },
            showAddTeamMemberDialog()
            {
                let vm = this;

                vm.dialogVisible = true;
            },
            handleClose(done) {
                this.$confirm('Are you sure to close this dialog?')
                    .then(_ => {
                        done();
                    })
                    .catch(_ => {});
            },
            addTeamMembers()
            {
                    let vm = this;
                    axios.post('/team/member/save', {
                        teamId: vm.teamId,
                        users: vm.selectedUsers
                    })
                        .then(function (response)
                        {
                            vm.dialogVisible = false;

                            vm.getTeamMembers();

                            if(response.data.success)
                            {
                                vm.$message({
                                    type: 'success',
                                    message: response.data.message
                                });

                            }
                            else
                            {
                                vm.$message({
                                    type: 'error',
                                    message: response.data.message
                                });
                            }
                        }).catch(function (error) {
                        console.log(error);
                    });
            },
            removeTeamMember(user)
            {
                let vm = this;
                axios.get('/api/team/'+vm.teamId+'/member/'+user.user_id+'/remove')
                    .then(function (response) {

                        if(response.data.success)
                        {
                            vm.$message({
                                type: 'success',
                                message: response.data.message
                            });

                            vm.getTeamMembers();

                        }
                        else
                        {
                            vm.$message({
                                type: 'error',
                                message: response.data.message
                            });
                        }
                    }).catch(function (error) {
                    console.log(error);
                })
            },
            filterTag(value, row) {
                return row.tag === value;
            },
            userName (option) {
                return `${option.label}`
            },
            contacts(user)
            {
                window.location.href = '/contacts/user/'+user.user_id;
            },
            interactions(user)
            {
                window.location.href = '/interactions/user/'+user.user_id;
            },
            activities(user)
            {
                window.location.href = '/activities/'+user.user_id;
            }
        }
    }
</script>

<style>
    .el-table{
        border-left: none;
        border-right: none;
    }
    .el-select{
        width:  100%;
    }
</style>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>