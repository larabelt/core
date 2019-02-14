@php
    $fixed = $fixed ?? false;
    $width = $width ?? 0;
    $height = $height ?? 0;
    $heightStyle = $height ? sprintf('height:%spx', $height) : '';
    $style = "$heightStyle";
@endphp

@if($fixed && $width && $height)
    <div class="" style="width:{{ $width < 700 ? $width : 700 }}px;overflow-x:auto;">
        <iframe
                class="embed-responsive-item"
                src="{{ $src }}"
                width="{{ $width }}px"
                height="{{ $height }}px"
                allowfullscreen
        ></iframe>
    </div>
@else
    <div class="embed-responsive embed-responsive-16by9" style="{{ $style }}">
        <iframe
                class="embed-responsive-item"
                src="{{ $src }}"
                allowfullscreen
        ></iframe>
    </div>
@endif