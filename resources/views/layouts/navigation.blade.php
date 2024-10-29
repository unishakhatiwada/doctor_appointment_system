<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ url('/') }}">Doctor Appointment System</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            {{-- Dynamic menu items --}}
            @foreach($menuItems as $menuItem)
                @include('layouts.menu-item', ['menuItem' => $menuItem])
            @endforeach
        </ul>
    </div>
</nav>
