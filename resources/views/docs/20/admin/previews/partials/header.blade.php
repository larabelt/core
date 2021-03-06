<header class="main-header">
    <!-- Logo -->
    <a href="/" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>LB</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">{{ env('APP_NAME') }}</span>
    </a><!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        @include('belt-core::docs.20.admin.previews.partials.header-user-dropdown')
    </nav>
</header>