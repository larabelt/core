@yield('scripts-body-close')

@if( config('APP_DEBUG') )
    <script src="/plugins/tinymce/tinymce.dev.js"></script>
@else
    <script src="/plugins/tinymce/tinymce.min.js"></script>
@endif
<script src="{{ mix('/js/manifest.js') }}"></script>
<script src="{{ mix('/js/vendor.js') }}"></script>
<script src="{{ mix('/js/belt-all.js') }}"></script>