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
                            {{-- Display the title and type link --}}
                            @if($item->type == 'external_link')
                                <a href="{{ $item->external_link }}" target="_blank" class="font-weight-bold text-primary">
                                    <i class="fas fa-external-link-alt"></i> {{ $item->title }}
                                </a>
                            @else
                                <a href="{{ route('admin.'.$item->type .'s'. '.show', $item->typeItem->slug ?? '#') }}" class="font-weight-bold">
                                    {{ $item->title }}
                                </a>
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

                    {{-- Display child menu items, if any --}}
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
                                                <a href="{{ route($child->type .'s'. '.show', $child->typeItem->slug ?? '#') }}">
                                                    {{ $child->title }}
                                                </a>
                                            @endif

                                            {{-- Status and Display Badges for Child --}}
                                            <span class="badge ml-2 {{ $child->status ? 'badge-success' : 'badge-secondary' }}">
                                                {{ $child->status ? 'Active' : 'Inactive' }}
                                            </span>

                                            <span class="badge ml-1 {{ $child->display === 'visible' ? 'badge-info' : 'badge-dark' }}">
                                                {{ ucfirst($child->display) }}
                                            </span>
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
