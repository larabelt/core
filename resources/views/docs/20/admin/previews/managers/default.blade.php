@php
    $contents = $contents ?? 'default';
    $contentViewPath = "belt-core::docs.20.admin.previews.managers.contents.$contents";
@endphp

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    @include('belt-core::docs.20.admin.previews.managers.partials.window-config')
    <link rel="stylesheet" href="{{ static_url(mix('/css/belt.css')) }}">
    <style>
        a {
            pointer-events: none !important;
            cursor: default !important;
        }
    </style>
</head>

<body class="admin hold-transition skin-belt sidebar-mini">
<div class="wrapper">

    @include('belt-core::docs.20.admin.previews.managers.partials.header')

    <!-- Left side column. contains the logo and sidebar -->
    @include('belt-core::docs.20.admin.previews.sidebars.default')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section>
            <div class="row">
                <div class="col-lg-12">
                    <div id="belt-core">
                        @includeIf($contentViewPath)
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include('belt-core::docs.20.admin.previews.managers.partials.footer')

    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<script src="{{ static_url('/plugins/tinymce/tinymce.min.js') }}"></script>
<script src="{{ static_url(mix('/js/manifest.js')) }}"></script>
<script src="{{ static_url(mix('/js/vendor.js')) }}"></script>
<script src="{{ static_url(mix('/js/belt-all.js')) }}"></script>
</body>
</html>