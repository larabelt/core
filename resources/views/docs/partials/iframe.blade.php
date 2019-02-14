@php
    $height = isset($height) ? sprintf('height:%spx', $height) : '';
    $style = "$height";
@endphp

<div class="embed-responsive embed-responsive-16by9" style="{{ $style }}">
    <iframe
            class="embed-responsive-item"
            src="{{ $src }}"
            allowfullscreen
    ></iframe>
</div>