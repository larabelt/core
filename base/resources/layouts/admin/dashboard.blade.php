@extends('layouts::admin.main')

@section('main')
    <div class="box" ng-app="userApp" zng-controller="usersController">
        <div ng-view></div>
    </div>
@stop