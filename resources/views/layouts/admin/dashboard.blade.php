@extends('ohio-core::layouts.admin.main')

@section('heading-title', 'tmp')
@section('heading-subtitle', 'tmp')
@section('heading-active', 'tmp')

@section('scripts-body-close')
    @parent
    <script src="/client/core/base/admin/compiled.js"></script>
@endsection

@section('main')

    {{--<div ng-app="ohioApp" style="min-height: 500px;">--}}
        {{--@include('ohio-core::layouts.admin.partials.loading')--}}
        {{----}}
    {{--</div>--}}
    <div id="core-vue">
        <router-view></router-view>
    </div>

@stop