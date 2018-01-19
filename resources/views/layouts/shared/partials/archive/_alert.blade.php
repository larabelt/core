<div id="alert-{{ $alert->id }}" class="alert alert-warning" role="alert">
    {{ $alert->name }}: {{ $alert->body }}
    <span class="pull-right">
        <alert-dismissal :id="{{ $alert->id }}"></alert-dismissal>
    </span>
</div>