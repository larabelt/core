<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ $name }} <span class="caret"></span></a>
    <ul class="dropdown-menu">
        @foreach($menu->items() as $item)
            <li class="{{ $item->isCurrent() ? 'active' : '' }}">
                <a
                        href="{{ $item->getUri() }}"
                        target="{{ $item->getLinkAttribute('target') ?: 'default' }}"
                >{{ $item->getLabel() }}</a>
            </li>
        @endforeach
    </ul>
</li>