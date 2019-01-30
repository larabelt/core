@php
    $paramable = $paramable ?? null;
@endphp

@if( $paramable && $paramable instanceof \Belt\Core\Behaviors\ParamableInterface)
    @if( $paramable->param('jumbotron_enabled') )
        <div class="jumbotron">
            @if($image = $paramable->morphParam('jumbotron_image', null, 'attachments'))
                <img
                        class="img-responsive"
                        src="{{ clip($image)->src(1440) }}"
                        alt="{{ $image->alt }}"
                >
            @endif
            @if($title = $paramable->param('jumbotron_title'))
                <h1>{!! $title !!}</h1>
            @endif
            @if($text = $paramable->param('jumbotron_text'))
                <p>{!! $text !!}</p>
            @endif
            @if($button = $paramable->param('jumbotron_button_url'))
                <p><a
                            class="btn btn-primary btn-lg"
                            href="{{ $button }}"
                            target="_blank"
                    >{!! $paramable->param('jumbotron_button_text', 'READ MORE') !!}</a></p>
            @endif
        </div>
    @endif
@endif