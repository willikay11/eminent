<template>
</template>


<script>
    export default{
        data()
        {
            return {
                feedbackDialog: false
            }
        },

        methods: {
            showFeedbackDialog()
            {
                let vm = this;

                vm.feedbackDialog = true;
            }
        }
    }
</script>