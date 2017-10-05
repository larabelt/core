@php
    $collapsed = \Belt\Core\Helpers\CookieHelper::getJson('adminlte', 'collapsed', false);
@endphp

<!DOCTYPE html>
<html>
<head>
    @include('belt-core::layouts.admin.partials.head')
    @include('belt-core::layouts.admin.scripts.head-open')
    @include('belt-core::layouts.admin.scripts.auth')
    @include('belt-core::layouts.admin.scripts.active-team')
    @include('belt-core::layouts.admin.scripts.head-close')
    <link rel="stylesheet" href="{{ static_url(mix('/css/belt.css')) }}">
</head>

<body class="admin hold-transition skin-blue sidebar-mini {{ $team ? 'team' : '' }} {{ $collapsed ? 'sidebar-collapse' : '' }}">
@include('belt-core::layouts.admin.scripts.body-open')
<div class="wrapper">

    @include('belt-core::layouts.admin.partials.header')

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
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