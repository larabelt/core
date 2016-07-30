<!DOCTYPE html>
<html>
<head>
    @include('layout::admin.partials.head')
    @include('layout::admin.partials.scripts-head-close')
</head>
<body class="admin hold-transition skin-blue sidebar-mini">
@include('layout::admin.partials.scripts-body-open')
<div class="wrapper">
    @include('layout::admin.partials.header')
    @include('layout::admin.partials.sidebar-left')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @include('layout::admin.partials.heading')
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
    @include('layout::admin.partials.footer')
    @include('layout::admin.partials.sidebar-right')
</div>
<!-- ./wrapper -->
@include('layout::admin.partials.scripts-body-close')
</body>
</html>