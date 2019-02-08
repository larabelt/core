@php
    $alt = $alt ?? '';
    $caption = $caption ?? '';
    $src = $src ? "/storage/docs/$src" : '';
@endphp

![picture alt]({{ $src }} "{{ $alt }}")

@if($caption)
**{{ $caption }}**
@endif