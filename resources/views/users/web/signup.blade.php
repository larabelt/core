@extends('belt-core::layouts.web.main')

@section('main')

    @if($page)
        <div class="container">
            @include($page->subtype_view)
        </div>
    @endif

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <user-signup
                        redirect="/users/welcome"
                        label_is_opted_in="Yes! Sign me up for the occasional update."
                        label_submit_button="Sign Up"
                >
                </user-signup>
            </div>
        </div>
    </div>

@endsection