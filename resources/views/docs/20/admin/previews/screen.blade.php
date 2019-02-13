@php

    $style = request()->query('style', 'default');
    $styles = [
        "belt-$package::docs.$version.$subtype.previews.styles.$style",
        "belt-core::docs.$version.$subtype.previews.styles.$style",
        "belt-$package::docs.$version.$subtype.previews.styles.default",
        "belt-core::docs.$version.$subtype.previews.styles.default",
    ];

    $content = request()->query('content', 'default');
    $contents = [
        "belt-$package::docs.$version.$subtype.previews.contents.$content",
        "belt-core::docs.$version.$subtype.previews.contents.$content",
        "belt-$package::docs.$version.$subtype.previews.contents.default",
        "belt-core::docs.$version.$subtype.previews.contents.default",
    ];

    $sidebar = request()->query('sidebar', 'default');
    $sidebars = [
        "belt-$package::docs.$version.$subtype.previews.sidebars.$sidebar",
        "belt-core::docs.$version.$subtype.previews.sidebars.$sidebar",
        "belt-$package::docs.$version.$subtype.previews.sidebars.default",
        "belt-core::docs.$version.$subtype.previews.sidebars.default",
    ];

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
    @include('belt-core::docs.20.admin.previews.partials.window-config')
    <link rel="stylesheet" href="{{ static_url(mix('/css/belt.css')) }}">
    @includeFirst($styles)
</head>

<body class="admin hold-transition skin-belt sidebar-mini {{ request()->has('sidebar-collapse') ? 'sidebar-collapse' : '' }}">
<div class="wrapper">

    @include('belt-core::docs.20.admin.previews.partials.header')

    <!-- Left side column. contains the logo and sidebar -->
    @includeFirst($sidebars)

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section>
            <div class="row">
                <div class="col-lg-12">
                    <div id="belt-core">
                        @includeFirst($contents)
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include('belt-core::docs.20.admin.previews.partials.footer')

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