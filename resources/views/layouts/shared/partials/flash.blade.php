<div class="container">
    @if(isset($errors) && $errors->any())
        <div class="alert alert-danger">
            <ul>
                <li>{{ implode('</li><li>', $errors->all(':message')) }}</li>
            </ul>
        </div>
    @endif
    @if(Session::has('success'))
        <div class="alert alert-success">
            @include('belt-core::layouts.shared.partials._flash', ['msgs' => Session::get('success')])
        </div>
    @endif
    @if(Session::has('info'))
        <div class="alert alert-success">
            @include('belt-core::layouts.shared.partials._flash', ['msgs' => Session::get('info')])
        </div>
    @endif
    @if(Session::has('warning'))
        <div class="alert alert-warning">
            @include('belt-core::layouts.shared.partials._flash', ['msgs' => Session::get('warning')])
        </div>
    @endif
    @if(Session::has('danger'))
        <div class="alert alert-danger">
            @include('belt-core::layouts.shared.partials._flash', ['msgs' => Session::get('danger')])
        </div>
    @endif
    @if(isset($alerts) && $alerts)
        @each('belt-core::layouts.shared.partials._alert', $alerts, 'alert')
    @endif
</div>