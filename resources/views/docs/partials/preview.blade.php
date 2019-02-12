@php
    $package = $package ?? 'core';
    $version = $version ?? '20';
    $subtype = $subtype ?? 'admin';
    $path = $path ?? '';
    $views = [
        "belt-$package::docs.$version.$subtype.previews.$path",
        "belt-core::docs.$version.$subtype.previews.$path",
    ];
@endphp

@includeFirst($views, [
    'package' => $package,
    'subtype' => $subtype,
    'version' => $version,
])