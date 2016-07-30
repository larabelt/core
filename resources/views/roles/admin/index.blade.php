@extends('layout::admin.main')

@section('heading-title', 'Roles')
@section('heading-subtitle', 'control panel')
@section('heading-active', '<a href="/admin/roles/#!/index">Roles</a>')

@section('scripts-body-close')
    @parent
    <script src="/ng/roles/app.js"></script>
@endsection

@section('main')

    <div ng-app="rolesApp" style="min-height: 500px;">
        @include('layout::admin.partials.loading')
        <div ng-view></div>
    </div>

@stop