@extends('belt-core::layouts.web.main')

@section('main')

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <user-signup
                        redirect="/users/welcome"
                ></user-signup>
            </div>
        </div>
    </div>

@endsection