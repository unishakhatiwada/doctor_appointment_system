<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav ml-auto">
        {{-- Loop through the main menu items --}}
        @foreach($menuItems as $menuItem)
            @include('layouts.menu-item', ['menuItem' => $menuItem])
        @endforeach
    </ul>
</nav>
