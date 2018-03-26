@extends('layouts.default')

@section('content')

    <body class="hold-transition skin-blue sidebar-mini fixed">

    <div class="wrapper">

        @include('layouts.partials.header')

        @include('layouts.partials.sidebar')

        <div class="content-wrapper">

            @yield('main-content')

        </div>

        @include('layouts.partials.footer')

        @include('layouts.partials.control-sidebar')
    </div>

    </body>

@stop
