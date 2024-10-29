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
                @include('partials.menu-item', ['item' => $item])
            @endforeach
        </ul>
    @endif
@endsection
