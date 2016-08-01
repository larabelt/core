@extends('layouts::admin.main')

@section('heading-title', 'Users')
@section('heading-subtitle', 'control panel')
@section('heading-active', '<a href="/admin/users/#!/index">Users</a>')

@section('scripts-body-close')
    @parent
    <script src="/ohio/users/app.js"></script>
@endsection

@section('main')

    <div ng-app="usersApp" style="min-height: 500px;">
        @include('layouts::admin.partials.loading')
        <div ng-view></div>
    </div>

@stop