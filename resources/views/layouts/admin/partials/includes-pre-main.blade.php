@isset($includes)
    <div id="belt-app-pre-main">
        @foreach((array) $includes as $include)
            @include($include)
        @endforeach
    </div>
@endisset