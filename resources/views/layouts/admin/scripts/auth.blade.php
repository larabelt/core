@php
    $auth = Auth::user();
@endphp

<script>
    window.larabelt.auth = {!! json_encode([
        'is_super' => $auth->is_super,
        'first_name' => $auth->first_name,
        'last_name' => $auth->last_name,
        'email' => $auth->email,
        'username' => $auth->username,
        'roles' => $auth->roles->pluck('name')->toArray(),
        'teams' => $auth->teams->pluck('id')->toArray(),
    ])  !!}
</script>