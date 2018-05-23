<header class="main-header">
@include('belt-core::layouts.admin.partials.header-branding')
<!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user"></i>
                        @if($auth->first_name && $auth->last_name)
                            <span class="hidden-xs">{{ $auth->first_name }} {{ $auth->last_name }}</span>
                        @else
                            <span class="hidden-xs">{{ $auth->email }}</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <i class="fa fa-4x fa-user"></i>
                            <div>{{ Auth::user()->email }}</div>
                            @if($team)
                                <div><strong>{{ $team->name }}</strong></div>
                            @endif
                            <div><small>Member since {{ Auth::user()->created_at->format('M. Y') }}</small></div>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="/admin/belt/core/users/edit/{{ Auth::user()->id }}" class="btn btn-default btn-flat">Edit Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="/logout" class="btn btn-default btn-flat">Sign Out</a>
                            </div>
                        </li>
                    </ul>
                </li>
                @if(Auth::user()->teams->count() > 1)
                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a href="#control-sidebar-settings-tab" data-toggle="control-sidebar"><i class="i-team"></i></a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</header>