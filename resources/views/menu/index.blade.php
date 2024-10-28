@extends('admin.layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center text-primary bg-primary mb-4">
        <h2>Menu Items</h2>

    </div>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <a href="{{ route('menus.create') }}" class="btn btn-success">Create Menu</a>
    @if($menuItems->isEmpty())
        <div class="alert alert-info">No menu items available. Click "Create Menu" to add new items.</div>
    @else
        <ul class="list-group">
            @foreach($menuItems as $item)
                <li class="list-group-item">
                    <div class="d-flex justify-content-between">
                        <div>
                            @if($item->type == 'external_link')
                                <a href="{{ $item->external_link }}" target="_blank" class="font-weight-bold text-primary">
                                    <i class="fas fa-external-link-alt"></i> {{ $item->title }}
                                </a>
                            @else
                                <a href="{{ route($item->type . '.show', $item->typeItem->slug ?? '#') }}" class="font-weight-bold">
                                    {{ $item->title }}
                                </a>
                            @endif

                            @if(!$item->status)
                                <span class="badge badge-secondary ml-2">Inactive</span>
                            @endif
                        </div>

                        <div>
                            @include('components.action-button', [
                                'url' => route('menus.index') . '/', // Base URL for menu actions
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

                    @if($item->children->isNotEmpty())
                        <ul class="list-group mt-2 ml-4">
                            @foreach($item->children as $child)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            @if($child->type == 'external_link')
                                                <a href="{{ $child->external_link }}" target="_blank" class="text-primary">
                                                    <i class="fas fa-external-link-alt"></i> {{ $child->title }}
                                                </a>
                                            @else
                                                <a href="{{ route($child->type . '.show', $child->typeItem->slug ?? '#') }}">
                                                    {{ $child->title }}
                                                </a>
                                            @endif

                                            @if(!$child->status)
                                                <span class="badge badge-secondary ml-2">Inactive</span>
                                            @endif
                                        </div>

                                        <div>
                                            @include('components.action-button', [
                                                'url' => route('menus.index') . '/',
                                                'data' => $child,
                                                'buttons' => [
                                                    'view' => false,
                                                    'edit' => true,
                                                    'delete' => true,
                                                    'download' => false
                                                ]
                                            ])
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
@endsection
