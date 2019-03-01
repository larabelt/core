@extends('belt-core::layouts.web.main')

@section('main')

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h2>Login</h2>
                {!! Form::open(['url'=>'login', 'class'=> 'login']) !!}
                <div class="form-group">
                    {{ Form::text('email', null, ['class'=>'form-control', 'placeholder'=>'Email Address']) }}
                </div>
                <div class="form-group">
                    {{ Form::password('password', ['class'=>'form-control', 'placeholder'=>'Password']) }}
                </div>
                {{ Form::submit('Login', ['class'=>'btn btn-large btn-primary btn-block'])}}
                {{ Form::close() }}
                <br/>
                <span class="pull-left"><a class="btn" href="/password/forgot">FORGOT YOUR PASSWORD?</a></span>
            </div>
        </div>
    </div>

@endsection