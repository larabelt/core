@php
    $collapsed = \Belt\Core\Helpers\CookieHelper::getJson('adminlte', 'collapsed', false);
    $roles = '';

    if( isset($user_role_names) ) {
        foreach($user_role_names as $name => $title) {
            $roles .= "role_$name ";
        }
    }
@endphp

<!DOCTYPE html>
<html>
<head>
    @include('belt-core::layouts.admin.partials.head')
    @include('belt-core::layouts.admin.scripts.head-open')
    @include('belt-core::layouts.admin.scripts.head-close')
    @include('belt-core::layouts.admin.scripts.window-config')
    <link rel="stylesheet" href="{{ static_url(mix('/css/belt.css')) }}">
</head>

<body class="{{ $roles }}admin hold-transition skin-belt sidebar-mini {{ $team ? 'team' : '' }} {{ $collapsed ? 'sidebar-collapse' : '' }} {{ Translate::getAlternateLocale() ? 'alt-locale' : '' }}">
@include('belt-core::layouts.admin.scripts.body-open')
<div class="wrapper">

    @include('belt-core::layouts.admin.partials.header')

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            @include('belt-core::layouts.admin.partials.sidebar-left-top')
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                @include('belt-core::layouts.admin.partials.sidebar-left')
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

    @if($team)
        @include('belt-core::layouts.admin.partials.heading-team')
    @endif

    <!-- Main content -->
        <section>
            <div class="row">
                <div class="col-lg-12">
                    @include('belt-core::layouts.admin.partials.includes-pre-main')
                    @yield('main')
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include('belt-core::layouts.admin.partials.footer')
    @include('belt-core::layouts.admin.partials.sidebar-right')

    <div id="vue-modals">
        <modals></modals>
    </div>
</div>
<!-- ./wrapper -->
@include('belt-core::layouts.admin.scripts.body-close')
</body>
</html>