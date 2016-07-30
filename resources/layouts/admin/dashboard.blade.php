@extends('layout::admin.main')

{{--@section('heading')--}}
{{--<div class="heading clearfix">--}}
{{--<h1><i class="fa fa-briefcase"></i> <strong>Users</strong></h1>--}}

{{--<div class="heading-right">--}}
{{--<a class="btn" href="/admin/users/create">Add an user</a>--}}
{{--</div>--}}
{{--</div>--}}
{{--@stop--}}

@section('main')
    {{--@include('layout::admin.partials.fluff')--}}
    <div class="box" ng-app="userApp" zng-controller="usersController">
        <div ng-view></div>
    </div>
@stop