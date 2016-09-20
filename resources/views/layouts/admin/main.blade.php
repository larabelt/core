<!DOCTYPE html>
<html>
<head>
    @include('layouts::admin.partials.head')
    @include('layouts::admin.partials.scripts-head-close')
</head>
<body class="admin hold-transition skin-blue sidebar-mini">
@include('layouts::admin.partials.scripts-body-open')
<div class="wrapper">
    @include('layouts::admin.partials.header')
    @include('layouts::admin.partials.sidebar-left')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @include('layouts::admin.partials.heading')
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
    @include('layouts::admin.partials.footer')
    @include('layouts::admin.partials.sidebar-right')
</div>
<!-- ./wrapper -->
@include('layouts::admin.partials.scripts-body-close')
</body>
</html>