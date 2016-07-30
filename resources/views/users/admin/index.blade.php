@extends('layout::admin.main')

@section('heading-title', 'Users')
@section('heading-subtitle', 'control panel')
@section('heading-active', '<a href="/admin/users/#!/index">Users</a>')

@section('scripts-body-close')
    @parent
    <script src="/ng/users/app.js"></script>
@endsection

@section('main')

    <div ng-app="usersApp" style="min-height: 500px;">
        @include('layout::admin.partials.loading')
        <div ng-view></div>
    </div>

@stop