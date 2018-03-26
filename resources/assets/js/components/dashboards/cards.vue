<script>
    export default {
        data() {
            return {
                data: [],
                loading: false
            }
        },
        created: function () {
            let vm = this;

            vm.getCardData();
        },
        methods: {
            getCardData()
            {
                let vm = this;

                vm.loading = true;

//                axios.get('/api/dashboard/cards')
//                    .then(function (response) {
//                        vm.data = response.data;
//                        vm.loading = false;
//                    }).catch(function (error) {
//                    console.log(error);
//                })
            },
        }
    }
</script>