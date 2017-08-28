@yield('scripts-head-close')

<script>
    window.larabelt.coords = {!! json_encode([
        'gmaps_api_key' => env('GMAPS_API_KEY'),
        'lat' => env('COORDS_LAT', 39.9612),
        'lng' => env('COORDS_LNG', -82.9988),
        'zoom' => env('COORDS_ZOOM', 17),
    ])  !!}
</script>