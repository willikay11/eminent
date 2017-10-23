@extends('layouts.default')

@section('content')

<div class="wrapper" id="app">
    <!-- Sidebar Holder -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3>Eminent Business Group</h3>
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
                    <li><a href="#">Roles</a></li>
                    <li><a href="#">Permissions</a></li>
                    <li><a href="#">Designations</a></li>
                    <li><a href="#">Professions</a></li>
                    <li><a href="#">All Contacts</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Page Content Holder -->
    <div id="content">

        <nav class="navbar navbar-default">
            <div class="container-fluid">

                <div class="navbar-header">
                    <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                        <i class="glyphicon glyphicon-align-left"></i>
                        <span>Toggle Sidebar</span>
                    </button>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#">Page</a></li>
                        <li><a href="#">Page</a></li>
                        <li><a href="#">Page</a></li>
                        <li><a href="#">Page</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <h2>Collapsible Sidebar Using Bootstrap 3</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

        <div class="line"></div>

        <h2>Lorem Ipsum Dolor</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

        <div class="line"></div>

        <h2>Lorem Ipsum Dolor</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

        <div class="line"></div>

        <h3>Lorem Ipsum Dolor</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    </div>
</div>

@stop
