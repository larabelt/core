@php
    $src = $src ?? '';
    $img = $img ?? new \Belt\Content\Attachment(['src' => $src]);
@endphp

![picture alt]({{ clip($img)->src() }} "")

![picture alt]({{ $src }} "")

111

{{ $src }}

{{ clip($img)->src() }}

222