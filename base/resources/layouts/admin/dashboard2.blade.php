@extends('layouts::admin.main')

@section('heading-title', 'tmp')
@section('heading-subtitle', 'tmp')
@section('heading-active', 'tmp')

@section('scripts-body-close')
    @parent
    <script src="/client/core/base/admin/core.js"></script>
@endsection

@section('main')

    <div ng-app="ohioApp" style="min-height: 500px;">
        @include('layouts::admin.partials.loading')
        <div ng-view></div>
    </div>

@stop