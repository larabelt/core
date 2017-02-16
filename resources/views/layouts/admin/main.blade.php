<!DOCTYPE html>
<html>
<head>
    @include('belt-core::layouts.admin.partials.head')
    @include('belt-core::layouts.admin.partials.scripts-head-close')
    <link rel="stylesheet" href="/css/belt.css">
</head>
<body class="admin hold-transition skin-blue sidebar-mini">
@include('belt-core::layouts.admin.partials.scripts-body-open')
<div class="wrapper">
    @include('belt-core::layouts.admin.partials.header')
    @include('belt-core::layouts.admin.partials.sidebar-left')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
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

    <div id="vue-modals"><modals></modals></div>
</div>
<!-- ./wrapper -->
@include('belt-core::layouts.admin.partials.scripts-body-close')
</body>
</html>