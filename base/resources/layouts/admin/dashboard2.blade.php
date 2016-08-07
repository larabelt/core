@extends('layouts::admin.main')

@section('heading-title', 'tmp')
@section('heading-subtitle', 'tmp')
@section('heading-active', 'tmp')

@section('scripts-body-close')
    @parent
    <script src="/ng/core/base/admin/core.js"></script>
@endsection

@section('main')

    <p><a href="/admin/ohio/core/#!/users/index">hello world</a></p>

    <div ng-app="ohioApp" style="min-height: 500px;">
        @include('layouts::admin.partials.loading')
        <div ng-view></div>
    </div>

@stop