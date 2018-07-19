@extends('belt-core::layouts.web.main')

@section('main')

    @if($page)
        <div class="container">
            @include($page->subtype_view)
        </div>
    @else
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Welcome</h5>
                </div>
            </div>
        </div>
    @endif

@endsection