<template>
    <v-calendar :attributes='attrs' style="width: 100%; background-color: transparent; border: 0">
    </v-calendar>
</template>


<script>
    let today = new Date();

    export default {
        props: ['userId'],
        data() {
            return {
                loading: true,
                events: [],
                attrs: [
                    {
                        key: 'today',
                        color: '#ffffff',
                        highlight: {
                            backgroundColor: 'transparent',
                            // Other properties are available too, like `height` & `borderRadius`
                        },
                        dates: today
                    }
                ],
            };
        },
        created: function () {
            let vm = this;

            vm.getCalendar(null);
        },
        methods: {
            handleDayChanged (data) {
                console.log('date-changed', data)
            },
            handleMonthChanged (data) {
                this.getCalendar(data);
            },
            getCalendar(month = null)
            {
                month = 12;

                let vm = this;

                vm.loading = true;

                let url = '/api/dashboard/calendar/'+vm.userId+'/month';

                if (month != null)
                {
                    url = '/api/dashboard/calendar/'+vm.userId+'/month/'+month+'/year/2017'
                }

                axios.get(url)
                    .then(function (response) {
                        vm.events = response.data.calendar;
                        vm.loading = false;
                        console.log(vm.events);
                    }).catch(function (error) {
                    console.log(error);
                })
            },
            openActivity(activity)
            {
                window.location.href = '/activity/'+activity.id
            }
        }
    };
</script>