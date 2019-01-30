@php
    $links = [];
    $sectionable = $sectionable ?? new \Belt\Content\Page();
    if (Translate::isEnabled() && $sectionable instanceof \Belt\Content\Behaviors\HandleableInterface) {
        $links = $sectionable->getTranslatedLinks();
    }
@endphp

@if($links)
    <li class="dropdown">
        @foreach(Translate::getAvailableLocales() as $locale)
            @if($locale['code'] == Translate::getLocale())
                <a
                        href="#"
                        class="dropdown-toggle"
                        data-toggle="dropdown"
                        role="button"
                        aria-haspopup="true"
                        aria-expanded="false"
                >{{ $locale['label'] }} <span class="caret"></span></a>
                @break;
            @endif
        @endforeach
        <ul class="dropdown-menu">
            @foreach(Translate::getAvailableLocales() as $locale)
                @php
                    $link = array_get($links, $locale['code'], Request::fullUrlWithQuery(['locale' => $locale['code']]))
                @endphp
                <li><a href="{{ url($link) }}">{{ $locale['label'] }}</a></li>
            @endforeach
        </ul>
    </li>
@endif