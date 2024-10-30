@php use App\Helpers\MenuHelper; @endphp

<style>
    /* Position nested dropdowns properly */
    .dropdown-menu .dropdown-menu {
        left: 100%; /* Position nested menus to the right of their parent */
        top: 0;
        margin-left: 0.1rem;
    }

    /* Display dropdown on hover */
    .nav-item.dropdown:hover > .dropdown-menu {
        display: block;
    }
</style>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <div class="container-fluid justify-content-center">
        <ul class="navbar-nav h5"> <!-- Applying font size and padding here as a test -->
            {!! MenuHelper::renderMenuItems($menuHierarchy) !!}
        </ul>
    </div>
</nav>
