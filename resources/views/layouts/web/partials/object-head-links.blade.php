@php
    $default_locale = Translate::getDefaultLocale();
    $canon = Request::url();
    $links = [];
    $sectionable = $sectionable ?? new \Belt\Content\Page();
    if (Translate::isEnabled() && $sectionable instanceof \Belt\Content\Behaviors\HandleableInterface) {
        $links = $sectionable->getTranslatedLinks();
        if ($handle = $sectionable->getHandle(true, $default_locale)) {
            $canon = $handle->getReplacedUrl($default_locale);
        }
    }
@endphp

<link rel="canonical" href="{{ url($canon) }}">
@foreach($links as $code => $link)
    <link rel="alternate" hreflang="{{ $code }}" href="{{ url($link) }}">
@endforeach