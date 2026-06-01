<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href=".{{ url('/dashboard') }}" class="brand-link">
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

            <li class="nav-item @yield('student_mo')">
                <a href="#" class="nav-link @yield('student')">
                    <i class="nav-icon fas fa-user-graduate"></i>
                    <p>
                        Student
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('StudentAccess')
                        <li class="nav-item">
                            <a href="{{ url('student') }}" class="nav-link @yield('manage_student')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Manage Student</p>
                            </a>
                        </li>
                    @endcan
                    @can('StudentAttendanceReportAccess')
                        <li class="nav-item">
                            <a href="{{ url('student-attendance-report') }}" class="nav-link @yield('student_presence_report')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Attendance Report</p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>

            <li class="nav-item @yield('leave_mo')">
                <a href="#" class="nav-link @yield('leave')">
                    <i class="nav-icon fa fa-plane"></i>
                    <p>
                        Leave
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('CreateLeave')
                        <li class="nav-item">
                            <a href="{{ url('leave-track/create') }}" class="nav-link @yield('add_leave')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Add Leave</p>
                            </a>
                        </li>
                    @endcan
                    @can('ManageLeave')
                        <li class="nav-item">
                            <a href="{{ url('leave-track') }}" class="nav-link @yield('list_leave')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Manage Leave</p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>

            <li class="nav-item @yield('notice_mo')">
                <a href="#" class="nav-link @yield('notice')">
                    <i class="nav-icon fa fa-comments"></i>
                    <p>
                        Notice
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('ManageNotice')
                        <li class="nav-item">
                            <a href="{{ url('notice') }}" class="nav-link @yield('list_notice')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Manage Notice</p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>

            <li class="nav-item @yield('event_mo')">
                <a href="#" class="nav-link @yield('event')">
                    <i class="nav-icon fa fa-calendar"></i>
                    <p>
                        Events & Holidays
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('ViewEvents')
                        <li class="nav-item">
                            <a href="{{ url('event-calendar') }}" class="nav-link @yield('view_event')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>View Events</p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>

            <li class="nav-item @yield('timetable_mo')">
                <a href="#" class="nav-link @yield('timetable')">
                    <i class="nav-icon fa fa-map"></i>
                    <p>
                        Timetable
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('ClassRoutineViewAccess')
                        <li class="nav-item">
                            <a href="{{ route('class-routine.index') }}" class="nav-link @yield('view_class_timetable')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>View Routine</p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>

            <li class="nav-item @yield('exam_mo')">
                <a href="#" class="nav-link @yield('exam')">
                    <i class="nav-icon fa fa-graduation-cap"></i>
                    <p>
                        Exam & Marks
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('ManageExamReport')
                        <li class="nav-item">
                            <a href="{{ url('exam-report') }}" class="nav-link @yield('manage_exam_report')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Exam Report</p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>

            <li class="nav-item @yield('accounting_mo')">
                <a href="#" class="nav-link @yield('accounting')">
                    <i class="nav-icon fa fa-calculator"></i>
                    <p>
                        Accounting
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('ManageAssignSfees')
                        <li class="nav-item">
                            <a href="{{ url('manage-assign-fees') }}" class="nav-link @yield('manage_assign_sFee')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Assigned Fees</p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>

            <li class="nav-item @yield('transport_mo')">
                <a href="#" class="nav-link @yield('transport')">
                    <i class="nav-icon fa fa-bus"></i>
                    <p>
                        Transportation
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('TransportFees')
                        <li class="nav-item">
                            <a href="{{ url('accounting-transport') }}" class="nav-link @yield('manage_transport_fees')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Manage Transport Fees</p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>


            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>
