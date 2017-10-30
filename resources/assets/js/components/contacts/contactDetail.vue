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

                <el-row :gutter="20">
                    <el-col :span="4">
                        <div class="avatar"></div>
                    </el-col>
                    <el-col :span="20">
                        <el-col :span="24">
                            <h4>Mr. Test Test</h4>
                        </el-col>

                        <el-col :span="24" class="contact-row">
                            <span>Contact assigned to William Kamuyu</span>
                        </el-col>

                        <el-col :span="24" class="contact-row">
                            <i class="el-icon-message"></i><a href="#" class="span-holder"> &nbsp; willikay11@gmail.com</a>
                        </el-col>

                        <el-col :span="24" class="contact-row">
                            <i class="el-icon-message"></i><a href="#" class="span-holder"> &nbsp; 0789656789</a>
                        </el-col>

                        <el-col :span="24" class="contact-row">
                            <i class="el-icon-time"></i><a href="#" class="span-holder"> &nbsp; October 29, 2017 05:25</a>
                        </el-col>
                    </el-col>
                </el-row>
            </div>
        </div>
    </div>
</template>

<script>

</script>

<style>
    .contact-container{
        margin-left: 20px;
        margin-right: 20px;
    }
    .avatar{
        margin-right: 40px;
        height: 150px;
        max-width: 150px;
        min-width: 150px;
        background: rgba(163, 207, 95, 0.15);
        border: 1px solid rgba(163, 207, 95, 0.5);
    }
    .span-holder{
        display: inline-block;
    }
    .contact-row{
        margin-top: 10px;
    }
</style>