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
                    <div v-if="props.showEvents.length != 0"
                         v-for="(event, index) in props.showEvents"
                         class="event-item row"
                         v-bind:class="[event.status == 1 ? 'to-do-task' : event.status == 2 ? 'in-progress-task' : event.status == 3 ? 'in-review-task' : event.status == 4 ? 'completed-task' : '']">
                        <span class="col-lg-2 col-md-2 col-sm-2 col-xs-2 date-holder">
                            <p class="new-date">{{ event.formattedDate }}</p>
                        </span>

                        <span class="col-lg-8 col-md-8 col-sm-8 col-xs-8 task-holder">
                            <span class="title-holder">
                                <p class="new-title">{{ event.title }}</p>
                            </span>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <span class="task-date">{{ event.days.daysRemaining }}</span>
                                <span class="task-days">{{ event.days.content }}</span>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <el-progress type="line" :percentage="event.percentage"></el-progress>
                            </div>
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

    .__vev_calendar-wrapper .cal-wrapper .cal-body .dates .item .date-num {
        font-size: 1.3rem;
    }

    .date-holder{
        /*width: 9%;*/
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
        font-weight: 400;
    }

    .__vev_calendar-wrapper .events-wrapper .event-item {
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .task-holder{
        vertical-align: top;
        border: 1px solid #d4dbe4;
        padding: 15px;
        width: 80%;
        border-radius: 5px;
    }

    .task-date{
        font-size: 30px;
        vertical-align: top;
    }

    .task-days{

    }

    .to-do-task{
        border-left: 20px solid #e53e52;
    }

    .in-progress-task{
        border-left: 20px solid #f5a622;
    }

    .in-review-task{
        border-left: 20px solid #4a8fe3;
    }

    .completed-task{
        border-left: 20px solid #12884b;
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