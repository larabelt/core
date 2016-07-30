@extends('layout::admin.main')

@section('heading-title', 'tmp')
@section('heading-subtitle', 'tmp')
@section('heading-active', 'tmp')

@section('scripts-body-close')
    @parent
    <script src="/ng/admin-app.js"></script>
@endsection

@section('main')

    <p><a href="/admin/ohio-cms/admin/#!/users/index">hello world</a></p>

    <div ng-app="ohioApp" style="min-height: 500px;">
        @include('layout::admin.partials.loading')
        <div ng-view></div>
    </div>

@stop