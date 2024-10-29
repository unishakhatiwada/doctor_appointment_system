<li class="nav-item dropdown">
    @if($menuItem->children->isNotEmpty())
        {{-- Parent item with children - Dropdown Toggle --}}
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            {{ $menuItem->title }}
        </a>
        <ul class="dropdown-menu border-0 shadow">
            @foreach($menuItem->children as $child)
                @include('layouts.menu-item', ['menuItem' => $child])
            @endforeach
        </ul>
    @else
        {{-- Single item without children --}}
        <a href="{{ $menuItem->type === 'external_link' ? $menuItem->external_link : route($menuItem->type .'s'. '.show', $menuItem->type_id) }}" class="nav-link">
            {{ $menuItem->title }}
        </a>
    @endif
</li>
