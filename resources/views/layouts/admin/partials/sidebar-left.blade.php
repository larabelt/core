<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/img/demo/jake.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->email }}</p>
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
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user"></i> <span>User Admin</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/admin/ohio/core/users"><i class="fa fa-users"></i> <span>Users</span></a></li>
                    <li><a href="/admin/ohio/core/roles"><i class="fa fa-users"></i> <span>Roles</span></a></li>
                </ul>
            </li>
            @if(in_array('Ohio\Content\Base\OhioContentServiceProvider', array_keys(app()->getLoadedProviders())))
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-th-large"></i> <span>Content Admin</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="/admin/ohio/content/pages"><i class="fa fa-file-text"></i> <span>Pages</span></a></li>
                    </ul>
                    <ul class="treeview-menu">
                        <li><a href="/admin/ohio/content/handles"><i class="fa fa-link"></i> <span>Handles</span></a></li>
                    </ul>
                </li>
            @endif
            <li class="header">LABELS</li>
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>