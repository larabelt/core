@extends('ohio-core::layouts.admin.main')

@section('heading-title', 'tmp')
@section('heading-subtitle', 'tmp')
@section('heading-active', 'tmp')

@section('scripts-body-close')
    @parent
    <script src="/js/ohio-core.js"></script>
@endsection

@section('main')

    <div id="ohio-core">
        <router-view></router-view>
    </div>

@stop