<div class="box" style="margin-bottom: 0;">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-users"></i> {{ $team->name }}</h3>
        @if(Auth::user()->is_super)
            <span class="pull-right">
                <a href="{{ request()->fullUrlWithQuery(['team_id' => 0]) }}"><i class="fa fa-times"></i></a>
            </span>
        @endif
    </div>
</div>