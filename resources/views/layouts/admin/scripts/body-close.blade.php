@yield('scripts-body-close')

@if(env('APP_DEBUG'))
    <script src="{{ static_url('/plugins/tinymce/tinymce.dev.js') }}"></script>
@else
    <script src="{{ static_url('/plugins/tinymce/tinymce.min.js') }}"></script>
@endif
<script src="{{ static_url(mix('/js/manifest.js')) }}"></script>
<script src="{{ static_url(mix('/js/vendor.js')) }}"></script>
<script src="{{ static_url(mix('/js/belt-all.js')) }}"></script>