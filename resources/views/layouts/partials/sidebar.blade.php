<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/img/no-avatar.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{!! Auth::user()->contact->firstname.' '.Auth::user()->contact->lastname !!}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                  </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li><a href="/"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <li><a href="/contacts/user"><i class="fa fa-money"></i> <span>Contacts</span></a></li>
            <li><a href="/interactions/user"><i class="fa fa-car"></i> <span>Interactions</span></a></li>
            <li><a href="/reports"><i class="fa fa-file"></i> <span>Reports</span></a></li>
            <li><a href="/activities"><i class="fa fa-users"></i> <span>Activities</span></a></li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-unlock"></i>
                    <span>Admin</span>
                    <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/users"><i class="fa fa-user-plus"></i> Users</a></li>
                    <li><a href="/roles"><i class="fa fa-circle-o"></i> Roles</a></li>
                    <li><a href="/permissions"><i class="fa fa-circle-o"></i> Permissions</a></li>
                    <li><a href="/sources"><i class="fa fa-circle-o"></i> Sources</a></li>
                    <li><a href="/services"><i class="fa fa-circle-o"></i> Services</a></li>
                    <li><a href="/team"><i class="fa fa-circle-o"></i> Team</a></li>
                    <li><a href="/departments"><i class="fa fa-circle-o"></i> Departments</a></li>
                    <li><a href="/designations"><i class="fa fa-circle-o"></i> Designations</a></li>
                    <li><a href="/professions"><i class="fa fa-circle-o"></i> Professions</a></li>
                    <li><a href="/contacts"><i class="fa fa-circle-o"></i> Contacts</a></li>
                </ul>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>