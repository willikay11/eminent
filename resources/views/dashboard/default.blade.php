@extends('layouts.default')

@section('content')

    <div class="wrapper">
        <!-- Sidebar Holder -->
        <nav id="sidebar" class="active">
            <div class="sidebar-header">
                <h4>Eminent Business Group</h4>
                <strong>EBG</strong>
            </div>

            <ul class="list-unstyled components">
                <li class="active">
                    <a href="/">
                        <i class="glyphicon glyphicon-home"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="/contacts/user">
                        <i class="glyphicon glyphicon-briefcase"></i>
                        Contacts
                    </a>
                    <a href="/interactions/user">
                        <i class="glyphicon glyphicon-duplicate"></i>
                        Interactions
                    </a>
                </li>
                {{--<li>--}}
                    {{--<a href="#">--}}
                        {{--<i class="glyphicon glyphicon-link"></i>--}}
                        {{--Reports--}}
                    {{--</a>--}}
                {{--</li>--}}
                <li>
                    <a href="/activities">
                        <i class="glyphicon glyphicon-paperclip"></i>
                        Activities
                    </a>
                </li>
                @if(!empty(array_intersect([1, 5, 15, 16, 17, 18, 19, 20, 21, 22], getPermissions())))
                    <li>
                        <a href="#adminSubMenu" data-toggle="collapse" aria-expanded="false">
                            <i class="glyphicon glyphicon-duplicate"></i>
                            Admin
                        </a>
                        <ul class="collapse list-unstyled" id="adminSubMenu">
                            @if(in_array(1, getPermissions()))
                                <li><a href="/users">Users</a></li>
                            @endif

                            @if(in_array(15, getPermissions()))
                                <li><a href="/roles">Roles</a></li>
                            @endif

                            @if(in_array(16, getPermissions()))
                                <li><a href="/permissions">Permissions</a></li>
                            @endif
                            @if(in_array(17, getPermissions()))
                                <li><a href="/sources">Sources</a></li>
                            @endif
                            @if(in_array(18, getPermissions()))
                                <li><a href="/services">Services</a></li>
                            @endif
                            @if(in_array(19, getPermissions()))
                                <li><a href="/team">Teams</a></li>
                            @endif
                            @if(in_array(20, getPermissions()))
                                <li><a href="/departments">Departments</a></li>
                            @endif
                            @if(in_array(21, getPermissions()))
                                <li><a href="/designations">Designations</a></li>
                            @endif
                            @if(in_array(22, getPermissions()))
                                <li><a href="/professions">Professions</a></li>
                            @endif
                            @if(in_array(5, getPermissions()))
                                <li><a href="/contacts">All Contacts</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
            </ul>
        </nav>

        <!-- Page Content Holder -->
        <div id="content">

            <!-- Fixed navbar -->
            <div id="fixedNav" class="navbar navbar-fixed-top active" role="navigation">
                    <div class="navbar-header">
                        <div class="navbar-left">
                            {{--<button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">--}}
                                {{--<i class="glyphicon glyphicon-align-left"></i>--}}
                                {{--<span></span>--}}
                            {{--</button>--}}
                        </div>
                    </div>
                    <div class="navbar-right" style="margin-right: 40px">
                        <a href="/logout">
                            <span style="margin-right: 10px; margin-top: 7px;margin-bottom: 7px;">{{ \Illuminate\Support\Facades\Auth::user()->contact->present()->fullName }}</span>
                            <i class="glyphicon glyphicon-log-in"></i>
                        </a>
                    </div>
            </div>

            <div class="row content-container">

                @yield('dashboard-content')

            </div>

        </div>
    </div>

@stop
