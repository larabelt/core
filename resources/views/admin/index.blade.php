@extends('base::admin.main')

@section('main')

    <div class="container">
        <h1>Admin</h1>
        <p>Hello {{ Auth::user()->username }}</p>
    </div>

@endsection