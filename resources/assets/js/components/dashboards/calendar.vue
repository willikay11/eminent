<template>
    <div class="panel panel-default contact-panel-left contact-panel">
        <div class="col-lg-12 panel-header">
            <div class="col-lg-6">
                <h4>Calendar</h4>
            </div>
        </div>
        <div class="panel-body">
            <vue-event-calendar :events="events"
                                v-loading.body="loading"
                                @day-changed="handleDayChanged"
                                @month-changed="handleMonthChanged">
                <template slot-scope="props">
                    <div v-if="props.showEvents.length != 0" v-for="(event, index) in props.showEvents" class="event-item">
                        <span class="date-holder">
                            <p class="new-date">{{ event.formattedDate }}</p>
                        </span>

                        <span class="title-holder">
                            <p class="new-title">{{ event.title }}</p>
                            <p>Task is due on {{ event.formattedDate }}</p>
                        </span>
                    </div>

                    <div v-if="props.showEvents.length == 0" class="event-item">
                        <span class="title-holder">
                            <p class="new-title">No Events for this month</p>
                        </span>
                    </div>
                </template>
            </vue-event-calendar>
        </div>
    </div>
</template>

<script>
    let today = new Date();
    export default {
        props: ['userId'],
        data () {
            return {
                loading: true,
                events: []
            }
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
                let vm = this;

                vm.loading = true;

                let url = '/api/dashboard/calendar/'+vm.userId+'/month';

                if (month != null)
                {
                    url = '/api/dashboard/calendar/'+vm.userId+'/month/'+month
                }

                axios.get(url)
                    .then(function (response) {
                        vm.events = response.data.calendar;
                        vm.loading = false;
                    }).catch(function (error) {
                    console.log(error);
                })
            }
        }
    }
</script>

<style>

    .__vev_calendar-wrapper {
         max-width: 100%;
    }

    .__vev_calendar-wrapper .cal-wrapper {
        padding: 0px 10px 0px 0px;
    }

    .__vev_calendar-wrapper .cal-wrapper .cal-header {
        background-color: #455060;
    }

    .__vev_calendar-wrapper .arrow-left.icon:before {
        color: white;
    }

    .__vev_calendar-wrapper .arrow-right.icon:before {
        color: white;
    }

    .__vev_calendar-wrapper .cal-wrapper .cal-header .title {
        color: white;
    }

    .__vev_calendar-wrapper .cal-wrapper .cal-body .dates .item .is-today {
        content: "";
        color: white;
        background-color: #409eff !important;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        position: absolute;
        left: 50%;
        top: 50%;
        z-index: 1;
        margin-left: -18px;
        margin-top: -19px;
    }

    .__vev_calendar-wrapper .cal-wrapper .cal-body {
        background-color: white;
    }

    .__vev_calendar-wrapper .cal-wrapper .cal-body .weeks .item {
        color: #455060;
    }

    .__vev_calendar-wrapper .cal-wrapper .cal-body .dates .item .date-num {
        color: #455060 !important;
    }

    .__vev_calendar-wrapper .events-wrapper {
        border-radius: 0px;
        background-color: #454f5f !important;
    }

    .__vev_calendar-wrapper .events-wrapper .event-item {
        padding: 5px 20px;
        margin-top: 5px;
        box-shadow: none;
        background-color: #fff;
        border-radius: 3px;
        color: #323232;
        position: relative;
        border-bottom: 1px solid;
        border-left: 6px solid #e6934b;
    }

    .__vev_calendar-wrapper .events-wrapper .date {
        max-width: 100%;
        min-width: 200px;
        text-align: left;
        color: white;
        background-color: transparent;
        border-radius: 0px;
        margin: 0 auto;
        font-size: 22px;
    }

    .date-holder{
        width: 9%;
        word-wrap: break-word;
        margin-right: 5px;
    }

    .new-date{
        font-size: 22px;
        line-height: 28px;
        font-weight: 600;
    }

    .title-holder{
        vertical-align: top;
    }

    .new-title{
        font-size: 20px;
        text-transform: uppercase;
        font-weight: 400;
    }

    .__vev_calendar-wrapper .events-wrapper .event-item {
        padding-top: 10px;
        padding-bottom: 10px;
    }

    /* Custom, iPhone Retina */
    @media only screen and (min-width : 320px) {
        .new-date{
            font-size: 15px;
        }

        .new-title{
            font-size: 18px;
        }
    }

    /* Extra Small Devices, Phones */
    @media only screen and (min-width : 480px) {
        .new-date{
            font-size: 15px;
        }

        .new-title{
            font-size: 18px;
        }
    }

    /* Small Devices, Tablets */
    @media only screen and (min-width : 768px) {
        .new-date{
            font-size: 17px;
        }

        .new-title{
            font-size: 20px;
        }
    }

    /* Medium Devices, Desktops */
    @media only screen and (min-width : 992px) {
        .new-date{
            font-size: 17px;
        }

        .new-title{
            font-size: 20px;
        }
    }

    /* Large Devices, Wide Screens */
    @media only screen and (min-width : 1200px) {
        .new-date{
            font-size: 22px;
        }

        .new-title{
            font-size: 20px;
        }
    }

    /*#app {*/
    /*font-family: 'Avenir', Helvetica, Arial, sans-serif;*/
    /*-webkit-font-smoothing: antialiased;*/
    /*-moz-osx-font-smoothing: grayscale;*/
    /*color: #2c3e50;*/
    /*margin-top: 30px;*/
    /*}*/

    /*h1, h2, h3 {*/
        /*font-weight: normal;*/
        /*margin: 0;*/
        /*padding: 0;*/
    /*}*/

    /*ul {*/
        /*list-style-type: none;*/
        /*padding: 0;*/
    /*}*/

    /*li {*/
        /*display: inline-block;*/
        /*margin: 0 10px;*/
    /*}*/

    /*a {*/
        /*color: #42b983;*/
    /*}*/

    /*.t-center {*/
        /*text-align: center;*/
        /*margin: 20px;*/
    /*}*/

    /*.mt150 {*/
        /*margin-top: 150px;*/
    /*}*/
</style>