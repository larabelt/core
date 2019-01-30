@foreach($menu->items() as $item)
    <li class="{{ $item->isCurrent() ? 'active' : '' }}">
        <a
                href="{{ $item->getUri() }}"
                target="{{ $item->getLinkAttribute('target') ?: 'default' }}"
        >{{ $item->getLabel() }}</a>
    </li>
@endforeach