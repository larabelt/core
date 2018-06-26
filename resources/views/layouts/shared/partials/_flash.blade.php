@if(isset($msgs))
    <ul>
        @foreach((array) $msgs as $msg)
            <li>{{ $msg }}</li>
        @endforeach
    </ul>
@endif