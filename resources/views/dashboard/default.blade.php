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
                    <a href="#" aria-expanded="false">
                        <i class="glyphicon glyphicon-home"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="glyphicon glyphicon-briefcase"></i>
                        Contacts
                    </a>
                    <a href="#" aria-expanded="false">
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
                    <a href="#">
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
                        <li><a href="#">Users</a></li>
                        <li><a href="/roles">Roles</a></li>
                        <li><a href="/permissions">Permissions</a></li>
                        <li><a href="/designations">Designations</a></li>
                        <li><a href="/professions">Professions</a></li>
                        <li><a href="#">All Contacts</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        <!-- Page Content Holder -->
        <div id="content">

            <!-- Fixed navbar -->
            <div id="fixedNav" class="navbar navbar-fixed-top" role="navigation">
                    <div class="navbar-header">
                        <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                            <i class="glyphicon glyphicon-align-left"></i>
                            <span>Toggle Sidebar</span>
                        </button>
                    </div>
            </div>

            <div class="row content-container">

                @yield('dashboard-content')

            </div>

        </div>
    </div>

@stop
