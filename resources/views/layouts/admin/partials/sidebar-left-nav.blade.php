@php
    $can['users'] = $auth->can(['create','update','delete'], Belt\Core\User::class);
    $can['teams'] = $auth->can(['create','update','delete'], Belt\Core\Team::class);
    $can['roles'] = $auth->can(['create','update','delete'], Belt\Core\Role::class);
@endphp

<li id="core-admin-sidebar-left-dashboard"><a href="/admin"><i class="fa fa-tachometer"></i> <span>Dashboard</span></a></li>

@if($can['users'] || $can['teams'] || $can['roles'])
    <li id="core-admin-sidebar-left" class="treeview">
        <a href="#">
            <i class="fa fa-user-o"></i> <span>Access</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            @if($can['users'])
                <li id="core-admin-sidebar-left-users"><a href="/admin/belt/core/users"><i class="fa fa-user"></i> <span>Users</span></a></li>
            @endif
            @if($can['teams'])
                <li id="core-admin-sidebar-left-teams"><a href="/admin/belt/core/teams"><i class="fa i-team"></i> <span>Teams</span></a></li>
            @endif
            @if($can['roles'])
                <li id="core-admin-sidebar-left-roles"><a href="/admin/belt/core/roles"><i class="fa fa-key"></i> <span>Roles</span></a></li>
            @endif
        </ul>
    </li>
@endif

@if($team)
    <li id="core-admin-sidebar-left-team"><a href="/admin/belt/core/teams/edit/{{ $team->id }}"><i class="i-team"></i> <span>Team</span></a></li>
@endif