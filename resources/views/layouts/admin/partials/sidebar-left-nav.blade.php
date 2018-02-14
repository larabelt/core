@php
    $can['alerts'] = Auth::user()->can('edit', Belt\Core\Alert::class);
    $can['users'] = Auth::user()->can('edit', Belt\Core\User::class);
    $can['teams'] = Auth::user()->can('edit', Belt\Core\Team::class);
    $can['roles'] = Auth::user()->can('edit', Belt\Core\Role::class);
    $can['workRequests'] = Auth::user()->can('edit', Belt\Core\WorkRequest::class);
@endphp

@if($can['alerts'])
    <li><a href="/admin/belt/core/alerts"><i class="fa fa-bullhorn"></i> <span>Alerts</span></a></li>
@endif

@if($can['workRequests'])
    <li><a href="/admin/belt/core/work-requests"><i class="fa fa-tasks"></i> <span>Work Requests</span></a></li>
@endif

@if($can['users'] || $can['teams'] || $can['roles'])
    <li class="treeview">
        <a href="#">
            <i class="fa fa-user-o"></i> <span>User Admin</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            @if($can['users'])
                <li><a href="/admin/belt/core/users"><i class="fa fa-user"></i> <span>Users</span></a></li>
            @endif
            @if($can['teams'])
                <li><a href="/admin/belt/core/teams"><i class="fa fa-users"></i> <span>Teams</span></a></li>
            @endif
            @if($can['roles'])
                <li><a href="/admin/belt/core/roles"><i class="fa fa-key"></i> <span>Roles</span></a></li>
            @endif
        </ul>
    </li>
@endif

@if($team)
    <li><a href="/admin/belt/core/teams/edit/{{ $team->id }}"><i class="fa fa-users"></i> <span>Team</span></a></li>
@endif