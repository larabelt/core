<!DOCTYPE html>
<html>
<head>
    @include('ohio-core::layouts.admin.partials.head')
    @include('ohio-core::layouts.admin.partials.scripts-head-close')
</head>
<body class="admin hold-transition skin-blue sidebar-mini">
@include('ohio-core::layouts.admin.partials.scripts-body-open')
<div class="wrapper">
    @include('ohio-core::layouts.admin.partials.header')
    @include('ohio-core::layouts.admin.partials.sidebar-left')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @include('ohio-core::layouts.admin.partials.heading')
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
    @include('ohio-core::layouts.admin.partials.footer')
    @include('ohio-core::layouts.admin.partials.sidebar-right')
</div>
<!-- ./wrapper -->
@include('ohio-core::layouts.admin.partials.scripts-body-close')
</body>
</html>