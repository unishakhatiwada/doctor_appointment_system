@extends('admin.layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Menu Items</h2>
        <a href="{{ route('menus.create') }}" class="btn btn-primary">Create Menu</a>
    </div>

    <ul>
        @foreach($menuItems as $item)
            <li>
                @if($item->type == 'external_link')
                    <a href="{{ $item->external_link }}" target="_blank">{{ $item->title }}</a>
                @else
                    <a href="{{ route($item->type . '.show', $item->typeItem->slug ?? '#') }}">
                        {{ $item->title }}
                    </a>
                @endif

                @if($item->children->isNotEmpty())
                    <ul>
                        @foreach($item->children as $child)
                            <li>
                                <a href="{{ $child->type == 'external_link' ? $child->external_link : route($child->type . '.show', $child->typeItem->slug ?? '#') }}">
                                    {{ $child->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
@endsection
