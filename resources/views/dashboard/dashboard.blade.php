@extends('dashboard.default')

@section('main-content')

    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <section class="content">
        <!-- Small boxes (Stat box) -->

        <cards user-id="{!! $userId !!}" inline-template>
            <div class="row">
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>@{{ data.todo }}</h3>

                            <p>Todo Activities</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>@{{ data.ongoing }}</h3>

                            <p>Ongoing Activities</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="/customers" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>@{{ data.review }}</h3>

                            <p>In Review</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>@{{ data.complete }}</h3>

                            <p>Completed Activities</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </cards>

        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-6 connectedSortable">

                <div class="box box-success">
                    <div class="box-header">
                        <i class="fa fa-comments-o"></i>

                        <h3 class="box-title">Contacts</h3>
                    </div>
                    <div class="box-body chat" id="chat-box">
                        <dashboard-contacts user-id="{!! $userId !!}"></dashboard-contacts>
                    </div>

                    <div class="box-footer">
                        <div class="input-group">
                            <a href="/contacts/user" class="btn btn-block btn-primary">See More</a>
                        </div>
                    </div>
                </div>

                <!-- Calendar -->
                <div class="box box-solid bg-green-gradient">
                    <div class="box-header">
                        <i class="fa fa-calendar"></i>

                        <h3 class="box-title">Calendar</h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <!-- button with a dropdown -->
                            <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                            </button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <!--The calendar -->
                        <calendar-test  user-id="{!! $userId !!}" inline-template>
                            <div>
                                <v-calendar :attributes='attrs' style="width: 100%; background-color: transparent; border: 0">
                                </v-calendar>

                                <!-- /.box-body -->
                                <div class="box-footer text-black">
                                    <div class="row" v-if="events.length > 0">
                                        <div class="col-sm-6" v-for="event in events">
                                            <!-- Progress bars -->
                                            <div class="clearfix">
                                                <span class="pull-left">@{{ event.title }}</span>
                                                <small class="pull-right">@{{ event.percentage }}%</small>
                                            </div>
                                            <div class="progress xs">
                                                <div class="progress-bar progress-bar-green" v-bind:style="{ width: event.percentage + '%' }"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </div>
                            </div>
                        </calendar-test>
                    </div>
                </div>

            </section>
            <!-- /.Left col -->

            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-6 connectedSortable">

                <div class="box box-danger">
                    <div class="box-header">
                        <i class="fa fa-comments-o"></i>

                        <h3 class="box-title">Interactions</h3>
                    </div>
                    <div class="box-body chat" id="chat-box">
                        <dashboard-interactions user-id="{!! $userId !!}"></dashboard-interactions>
                    </div>

                    <div class="box-footer">
                        <div class="input-group">
                            <a href="/interactions/user" class="btn btn-block btn-primary">See More</a>
                        </div>
                    </div>
                </div>
            </section>
            <!-- right col -->
        </div>
        <!-- /.row (main row) -->

    </section>

@stop