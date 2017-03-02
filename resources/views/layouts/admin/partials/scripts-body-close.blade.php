@yield('scripts-body-close')

@if( config('APP_DEBUG') )
    <script src="/plugins/tinymce/tinymce.dev.js"></script>
@else
    <script src="/plugins/tinymce/tinymce.min.js"></script>
@endif
<script src="/js/manifest.js"></script>
<script src="/js/vendor.js"></script>
<script src="/js/belt-all.js"></script>

