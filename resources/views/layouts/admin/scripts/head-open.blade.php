<script>
    window.larabelt = {};
    window.larabelt.adminMode = {!! json_encode($team ? 'team' : 'admin') !!};
</script>