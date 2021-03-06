@extends('layouts.default')

@section('content')

    <div class="wrapper">
        <!-- Sidebar Holder -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h4>Eminent Business Group</h4>
                <strong>EBG</strong>
            </div>

            <ul class="list-unstyled components">
                <li class="active">
                    <a href="/" aria-expanded="false">
                        <i class="glyphicon glyphicon-home"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="/contacts/user">
                        <i class="glyphicon glyphicon-briefcase"></i>
                        Contacts
                    </a>
                    <a href="/interactions/user" aria-expanded="false">
                        <i class="glyphicon glyphicon-duplicate"></i>
                        Interactions
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="glyphicon glyphicon-link"></i>
                        Reports
                    </a>
                </li>
                <li>
                    <a href="/activities">
                        <i class="glyphicon glyphicon-paperclip"></i>
                        Activities
                    </a>
                </li>
                <li>
                    <a href="#adminSubMenu" data-toggle="collapse" aria-expanded="false">
                        <i class="glyphicon glyphicon-duplicate"></i>
                        Admin
                    </a>
                    <ul class="collapse list-unstyled" id="adminSubMenu">
                        <li><a href="/users">Users</a></li>
                        <li><a href="/roles">Roles</a></li>
                        <li><a href="/permissions">Permissions</a></li>
                        <li><a href="/sources">Sources</a></li>
                        <li><a href="/services">Services</a></li>
                        <li><a href="/departments">Departments</a></li>
                        <li><a href="/designations">Designations</a></li>
                        <li><a href="/professions">Professions</a></li>
                        <li><a href="/contacts">All Contacts</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        <!-- Page Content Holder -->
        <div id="content">

            <!-- Fixed navbar -->
            <div id="fixedNav" class="navbar navbar-fixed-top" role="navigation">
                    <div class="navbar-header">
                        <div class="navbar-left">
                            <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                                <i class="glyphicon glyphicon-align-left"></i>
                                <span></span>
                            </button>
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
