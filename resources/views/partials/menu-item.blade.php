
<li class="list-group-item">
    <div class="d-flex justify-content-between">
        <div>
            {{-- Link for Menu Item --}}
            @if($item->type == 'external_link')
                <a href="{{ $item->external_link }}" target="_blank" class="font-weight-bold text-primary">
                    <i class="fas fa-external-link-alt"></i> {{ $item->title }}
                </a>
            @elseif($item->type == 'module')
                <a href="{{ route('admin.modules.show', $item->typeItem->slug ?? '#') }}" class="font-weight-bold">
                    {{ $item->title }}
                </a>
            @elseif($item->type == 'page')
                <a href="{{ route('admin.pages.show', $item->typeItem->slug ?? '#') }}" class="font-weight-bold">
                    {{ $item->title }}
                </a>
            @else
                <a href="#" class="font-weight-bold">{{ $item->title }}</a>
            @endif

            {{-- Status and Display Badges --}}
            <span class="badge ml-2 {{ $item->status ? 'badge-success' : 'badge-secondary' }}">
                {{ $item->status ? 'Active' : 'Inactive' }}
            </span>

            <span class="badge ml-1 {{ $item->display === 'visible' ? 'badge-info' : 'badge-dark' }}">
                {{ ucfirst($item->display) }}
            </span>
        </div>

        <div>
            @include('components.action-button', [
                'url' => route('menus.index') . '/',
                'data' => $item,
                'buttons' => [
                    'view' => false,
                    'edit' => true,
                    'delete' => true,
                    'download' => false
                ]
            ])
        </div>
    </div>

    {{-- Recursive call for child menu items --}}
    @if($item->children->isNotEmpty())
        <ul class="list-group mt-2 ml-4">
            @foreach($item->children as $child)
                @include('partials.menu-item', ['item' => $child])
            @endforeach
        </ul>
    @endif
</li>
