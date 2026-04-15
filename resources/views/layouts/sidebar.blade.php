<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="./index.html" class="brand-link">
            <!--begin::Brand Image-->
            {{-- <img
              src="./assets/img/AdminLTELogo.png"
              alt="AdminLTE Logo"
              class="brand-image opacity-75 shadow"
            /> --}}
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">AdminLTE 4</span>
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="navigation"
              aria-label="Main navigation"
              data-accordion="false"
              id="navigation"
            >
            <li class="nav-item @yield('dashboard_mo')">
                <a href="{{ url('dashboard') }}" class="nav-link @yield('dashboard')">
                    <i class="nav-icon bi bi-speedometer"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <li class="nav-item @yield('user_mo')">
                <a href="#" class="nav-link @yield('user')">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        User
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('UserCreate')
                        <li class="nav-item">
                            <a href="{{ url('user/create') }}" class="nav-link @yield('add_user')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Add User</p>
                            </a>
                        </li>
                    @endcan
                    @can('UserAccess')
                        <li class="nav-item">
                            <a href="{{ url('user') }}" class="nav-link @yield('manage_user')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Manage User</p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>

            <li class="nav-item @yield('settings_mo')">
                <a href="#" class="nav-link @yield('settings')">
                    <i class="nav-icon bi bi-tools"></i>
                    <p>
                    Settings
                    <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('role') }}" class="nav-link @yield('manage_role')">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Role</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('setting') }}" class="nav-link @yield('manage_setting')">
                            <i class="far fa-circle nav-icon"></i>
                            <p>System Settings</p>
                        </a>
                    </li>
                </ul>
            </li>

            @if(Auth::user()->email=='superadmin@eidyict.com')
                <li class="nav-item @yield('superadmin_mo')">
                    <a href="#" class="nav-link @yield('superadmin')">
                        <i class="nav-icon fa fa-lock-open"></i>
                        <p>
                            Super Admin Menu
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('user-type') }}" class="nav-link @yield('manage_user_type')">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage User Type</p>
                            </a>
                        </li>

                        {{--                        @can('permission-access')--}}
                        <li class="nav-item">
                            <a href="{{ url('permission') }}" class="nav-link @yield('manage_permission')">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('all_settings.Permission') }}</p>
                            </a>
                        </li>
                        {{--@endcan--}}
                    </ul>
                </li>
            @endif


            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>
