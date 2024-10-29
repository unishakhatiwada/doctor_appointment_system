<li class="nav-item dropdown">
    @if($menuItem->children->isNotEmpty())
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown-{{ $menuItem->id }}" role="button"
           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ $menuItem->title }}
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown-{{ $menuItem->id }}">
            @foreach($menuItem->children as $child)
                @include('layouts.menu-item', ['menuItem' => $child])
            @endforeach
        </div>
    @else
        <a class="nav-link"
           href="{{ $menuItem->type === 'external_link' ? $menuItem->external_link : route($menuItem->type . '.show', $menuItem->type_id) }}">
            {{ $menuItem->title }}
        </a>
    @endif
</li>
