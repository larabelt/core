<script src="/js/admin-footer-lib.js"></script>

@yield('scripts-body-close')

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>