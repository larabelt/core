<script>
    window.larabelt.activeTeam = {!! json_encode($team ? $team->toArray() : [])  !!}
</script>