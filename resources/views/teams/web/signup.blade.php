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
                <h2>Create New Team</h2>
                <p>Fill out the form below to create a new team.</p>
                <team-signup
                        redirect="/teams/welcome"
                        user_error_msg_email="This email has already been taken. Please use another email or login."
                        user_label_is_opted_in="Yes! Sign me up for the occasional update."
                        user_label_submit_button="Continue"
                >
                    <span slot="step1_text">Step 1: User Info</span>
                    <span slot="step2_text">Step 2: Team Info</span>
                </team-signup>
            </div>
        </div>
    </div>

@endsection