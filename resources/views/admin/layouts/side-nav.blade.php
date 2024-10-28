<aside class="main-sidebar sidebar-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('admin.dashboard')}}" class="brand-link">
        <img src="{{asset('Admin/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Doctor Appointment</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('Admin/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{auth()->user()->name}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                    <a href="{{route('admin.dashboard')}}" class="nav-link ">
                        <i class="nav-icon fas  fa-hospital active"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                <li class="nav-item">
                    <a href="{{route('departments.index')}}" class="nav-link">
                        <i class="nav-icon fas fa fa-medkit"></i>
                        <p>
                            Departments
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('doctors.index')}}" class="nav-link "  >
                        <i class="nav-icon fas fa fa-user-md "></i>
                        <p>
                            Doctors
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('schedules.index')}}" class="nav-link "  >
                        <i class="nav-icons fas fa-calendar-week "></i>
                        <p>
                            Doctor's Schedule
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('menus.index')}}" class="nav-link "  >
                        <i class="nav-icons fas fa-calendar-plus"></i>
                        <p>
                            Menus
                        </p>
                    </a>
                </li>
                {{-- Indented Module Link --}}
                <li class="nav-item ml-4"> {{-- Adjust `ml-4` as needed for desired indentation --}}
                    <a href="{{route('module.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-folder"></i>
                        <p>Modules</p>
                    </a>
                </li>

                {{-- Indented Pages Link --}}
                <li class="nav-item ml-4">
                    <a href="{{route('page.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Pages</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
