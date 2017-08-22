<!DOCTYPE html>
<html>
<head>
    @include('belt-core::layouts.admin.partials.head')
    <script>
        window.larabelt = {};
        window.larabelt.adminMode = {!! json_encode($team ? 'team' : 'admin') !!};
    </script>
    @include('belt-core::layouts.admin.partials.scripts-auth')
    @include('belt-core::layouts.admin.partials.scripts-active-team')
    @include('belt-core::layouts.admin.partials.scripts-head-close')
    <link rel="stylesheet" href="/css/belt.css">
</head>
<body class="admin hold-transition skin-blue sidebar-mini {{ $team ? 'team' : '' }}">
@include('belt-core::layouts.admin.partials.scripts-body-open')
<div class="wrapper">
@include('belt-core::layouts.admin.partials.header')

<!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
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
        {{--<section class="content">--}}
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
@include('belt-core::layouts.admin.partials.scripts-body-close')
</body>
</html>