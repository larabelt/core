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
    <link rel="stylesheet" href="/css/app.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="/css/font-awesome.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="web">

@include('belt-core::layouts.web.partials.menu')

<div id="main" role="main">
    @include('belt-core::layouts.shared.partials.flash')
    <div id="app">@yield('main')</div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<!-- Latest compiled and minified JavaScript -->
<script src="/js/bootstrap.min.js"></script>
<script src="/js/manifest.js"></script>
<script src="/js/vendor.js"></script>
<script src="/js/web.js"></script>
</body>
</html>