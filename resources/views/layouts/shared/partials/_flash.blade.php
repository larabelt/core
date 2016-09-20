@if(isset($msgs))
    <ul>
        @if(is_array($msgs))
            @foreach($msgs as $msg)
                <li>{{ $msg }}</li>
            @endforeach
        @else
            <li>{{ $msgs }}</li>
        @endif
    </ul>
@endif