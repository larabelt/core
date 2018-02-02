<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="csrf-token" content="{!! csrf_token() !!}"/>
    <title>@yield('meta-title')</title>
    <meta name="description" content="@yield('meta-description')">
    <meta name="keywords" content="@yield('meta-keywords')">

    <!-- Bootstrap -->
    <!-- Superhero Theme: http://bootswatch.com/superhero -->
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    @include('belt-core::layouts.admin.scripts.window-config')
</head>
<body class="web">

@include('belt-core::layouts.web.partials.menu')

<div id="main" role="main">
    <div id="app">
        @include('belt-core::layouts.shared.partials.flash')
        @yield('main')
    </div>
</div>

<script src="{{ static_url(mix('/js/manifest.js')) }}"></script>
<script src="{{ static_url(mix('/js/vendor.js')) }}"></script>
<script src="{{ static_url(mix('/js/web.js')) }}"></script>
</body>
</html>