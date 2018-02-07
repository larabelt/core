<h6>Teams</h6>

<ul>
@foreach(Auth::user()->teams as $team)
    <li><a href="/admin/belt/core/teams/edit/{{ $team->id }}?active_team_id={{ $team->id }}">{{ $team->name }}</a></li>
@endforeach
</ul>