@extends('belt-core::layouts.admin.main')

@section('heading-title', 'tmp')
@section('heading-subtitle', 'tmp')
@section('heading-active', 'tmp')

@section('main')

    <div id="belt-core">
        <router-view></router-view>
    </div>

    {{--<section class="content-header">--}}
        {{--<h1><span><i class="fa fa-dashboard"></i> Dashboard</span></h1>--}}
    {{--</section>--}}
    {{--<div class="box">--}}
        {{--<div class="box-body" style="min-height: 500px;">--}}

        {{--</div>--}}
    {{--</div>--}}

@stop