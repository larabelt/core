<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        @yield('heading-title')
        <small>@yield('heading-subtitle', 'control panel')</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">@yield('heading-active')</li>
    </ol>
</section>