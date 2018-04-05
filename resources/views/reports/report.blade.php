@extends('dashboard.default')


@section('main-content')

    <section class="content">

            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <div class="pull-left">
                                <h3 class="box-title" style="padding-bottom: 25px">Activity Report</h3>
                            </div>
                        </div>

                        <activity-report user-id="{!! $userId !!}" report-id="{!! $reportId !!}">
                        </activity-report>

                    </div>
                </div>
            </div>
    </section>
@stop