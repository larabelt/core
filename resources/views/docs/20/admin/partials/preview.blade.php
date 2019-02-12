@php
    $package = $package ?? 'core';
    $path = $path ?? '';
    $path = "belt-$package::docs.20.admin.previews.$path";
@endphp

@includeIf($path, ['package' => $package])