<template>
    <div>
        <el-button v-show="show" :plain="true"></el-button>
    </div>
</template>

<script>
    export default {
        props:['message','type'],

        data() {
            return{
                show: false
            }
        },

        created(){
            if(this.message){
                this.flash(this.message, this.type);
            }
        },

        methods:{
            flash(message, type){
                this.show = true;

                this.$message({
                    message: message,
                    type: type
                });

                this.hide();
            },

            hide(){
                setTimeout(() => {
                    this.show = false;
                }, 1000);
            },
        }

    }
</script>