@php use App\Helpers\MenuHelper; @endphp

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <div class="container-fluid justify-content-center">
        <ul class="navbar-nav h5"> <!-- Applying font size and padding here as a test -->
            {!! MenuHelper::renderMenuItems($menuHierarchy) !!}
        </ul>
    </div>
</nav>
