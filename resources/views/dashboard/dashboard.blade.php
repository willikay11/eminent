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

        <cards inline-template>
            <div class="row">
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>5</h3>

                            <p>Activities</p>
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
                            <h3>2</h3>

                            <p>Contacts</p>
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
                            <h3>12</h3>

                            <p>Interactions</p>
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
                            <h3>12</h3>

                            <p>Something</p>
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

                        <h3 class="box-title">Upcoming Payments</h3>
                    </div>
                    <div class="box-body chat" id="chat-box">
                        <dashboard-contacts user-id="{!! $userId !!}"></dashboard-contacts>
                    </div>

                    <div class="box-footer">
                        <div class="input-group">
                            <a href="/sales" class="btn btn-block btn-primary">See More</a>
                        </div>
                    </div>
                </div>

                <div class="box box-default">
                    <div class="box-header">
                        <i class="fa fa-car"></i>

                        <h3 class="box-title">Inventory</h3>
                    </div>
                    <div class="box-body chat" id="chat-box">
                        <dashboard-interactions user-id="{!! $userId !!}"></dashboard-interactions>
                    </div>
                    <div class="box-footer">
                        <div class="input-group">
                            <a href="/vehicles" class="btn btn-block btn-primary">See More</a>
                        </div>
                    </div>
                </div>

                <div class="box box-success">
                    <div class="box-header">
                        <i class="fa fa-comments-o"></i>

                        <h3 class="box-title">Customers</h3>
                    </div>
                    <div class="box-body chat" id="chat-box">
                        <calendar user-id="{!! $userId !!}"></calendar>
                    </div>
                    <div class="box-footer">
                        <div class="input-group">
                            <a href="/customers" class="btn btn-block btn-primary">See More</a>
                        </div>
                    </div>
                </div>

            </section>
            <!-- /.Left col -->

            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-6 connectedSortable">

                <div class="box box-danger">
                    <div class="box-header">
                        <i class="fa fa-comments-o"></i>

                        <h3 class="box-title">Overdue Payments</h3>
                    </div>
                    <div class="box-body chat" id="chat-box">
                        {{--<overdue-payments></overdue-payments>--}}
                    </div>

                    <div class="box-footer">
                        <div class="input-group">
                            <a href="/sales" class="btn btn-block btn-primary">See More</a>
                        </div>
                    </div>
                </div>

                <div class="box box-warning">
                    <div class="box-header">
                        <i class="fa fa-comments-o"></i>

                        <h3 class="box-title">Sales</h3>
                    </div>
                    <div class="box-body chat" id="chat-box">
                        {{--<sales></sales>--}}
                    </div>

                    <div class="box-footer">
                        <div class="input-group">
                            <a href="/sales" class="btn btn-block btn-primary">See More</a>
                        </div>
                    </div>
                </div>

            </section>
            <!-- right col -->
        </div>
        <!-- /.row (main row) -->

    </section>

@stop