<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="{{ url('/dashboard') }}" class="brand-link">
            <!--begin::Brand Image-->
            {{-- <img
              src="./assets/img/AdminLTELogo.png"
              alt="AdminLTE Logo"
              class="brand-image opacity-75 shadow"
            /> --}}
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">{{ config('app.name', 'Laravel') }}</span>
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
{{-- @dd(Auth::user()->can('PortfolioTagManagement')) --}}
{{-- @dd(Auth::user()->can('FrontendSettings')) --}}
            <li class="nav-item @yield('frontend_mo')">
                <a href="#" class="nav-link @yield('frontend')">
                    <i class="nav-icon fa fa-eye"></i>
                    <p>
                        Frontend Settings
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="margin-left: 15px">
                    @can('FrontendSettings')
                        <li class="nav-item @yield('carousel_mo')">
                            <a href="#" class="nav-link @yield('carousel')">
                                <i class="nav-icon fa fa-clone"></i>
                                <p>
                                    Carousel
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-3" style="margin-left: 15px">
                                <li class="nav-item">
                                        <a href="{{ url('carousel/create') }}" class="nav-link @yield('add_carousel')">
                                            <i class="nav-icon bi bi-circle"></i>
                                            <p>Add Carousel</p>
                                        </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('carousel') }}" class="nav-link @yield('manage_carousel')">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Manage Carousel</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item @yield('about_us_mo')">
                            <a href="#" class="nav-link @yield('about_us')">
                                <i class="nav-icon fa fa-info-circle"></i>
                                <p>
                                    About Us
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-3" style="margin-left: 15px">
                                <li class="nav-item">
                                    <a href="{{ url('about-us') }}" class="nav-link @yield('manage_about_us')">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Manage About Us</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item @yield('portfolio_mo')">
                            <a href="#" class="nav-link @yield('portfolio')">
                                <i class="nav-icon fa fa-briefcase"></i>
                                <p>
                                    Portfolio
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-3" style="margin-left: 15px">
                                <li class="nav-item">
                                        <a href="{{ url('portfolio/create') }}" class="nav-link @yield('add_portfolio')">
                                            <i class="nav-icon bi bi-circle"></i>
                                            <p>Add Portfolio</p>
                                        </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('portfolio') }}" class="nav-link @yield('manage_portfolio')">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Manage Portfolio</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan
                </ul>
            </li>

            <li class="nav-item @yield('academic_mo')">
                <a href="#" class="nav-link @yield('academic')">
                    <i class="nav-icon fa fa-university"></i>
                    <p>
                        Academic Settings
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="margin-left: 15px">
                    @can('ClassAccess')
                        <li class="nav-item @yield('class_mo')">
                            <a href="#" class="nav-link @yield('class')">
                                <i class="nav-icon fa fa-map-signs"></i>
                                <p>
                                    Class
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-3" style="margin-left: 15px">
                                @can('ClassCreate')
                                    <li class="nav-item">
                                        <a href="{{ url('schoolClass/create') }}" class="nav-link @yield('add_class')">
                                            <i class="nav-icon bi bi-circle"></i>
                                            <p>Add Class</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('ClassAccess')
                                <li class="nav-item">
                                    <a href="{{ url('schoolClass') }}" class="nav-link @yield('manage_class')">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Manage Class</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('SectionAccess')
                        <li class="nav-item @yield('section_mo')">
                            <a href="#" class="nav-link @yield('section')">
                                <i class="nav-icon fa fa-sitemap"></i>
                                <p>
                                    Section
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-3" style="margin-left: 15px">
                                @can('SectionCreate')
                                    <li class="nav-item">
                                        <a href="{{ url('schoolSection/create') }}" class="nav-link @yield('add_section')">
                                            <i class="nav-icon bi bi-circle"></i>
                                            <p>Add Section</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('SectionAccess')
                                <li class="nav-item">
                                    <a href="{{ url('schoolSection') }}" class="nav-link @yield('manage_section')">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Manage Section</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('AcademicYearAccess')
                        <li class="nav-item @yield('academic_year_mo')">
                            <a href="#" class="nav-link @yield('academic_year')">
                                <i class="nav-icon fa fa-calendar-check"></i>
                                <p>
                                    Academic Year
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-3" style="margin-left: 15px">
                                @can('AcademicYearCreate')
                                    <li class="nav-item">
                                        <a href="{{ url('academicYear/create') }}" class="nav-link @yield('add_academic_year')">
                                            <i class="nav-icon bi bi-circle"></i>
                                            <p>Add Academic Year</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('AcademicYearAccess')
                                <li class="nav-item">
                                    <a href="{{ url('academicYear') }}" class="nav-link @yield('manage_academic_year')">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Manage Academic Year</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('TermAccess')
                        <li class="nav-item @yield('term_mo')">
                            <a href="#" class="nav-link @yield('term')">
                                <i class="nav-icon fa fa-tasks"></i>
                                <p>
                                    Term/Semester
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-3" style="margin-left: 15px">
                                @can('TermCreate')
                                    <li class="nav-item">
                                        <a href="{{ url('term/create') }}" class="nav-link @yield('add_term')">
                                            <i class="nav-icon bi bi-circle"></i>
                                            <p>Add Term</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('TermAccess')
                                <li class="nav-item">
                                    <a href="{{ url('term') }}" class="nav-link @yield('manage_term')">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Manage Term</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('SubjectAccess')
                        <li class="nav-item @yield('subject_mo')">
                            <a href="#" class="nav-link @yield('subject')">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Subject
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-3" style="margin-left: 15px">
                                @can('SubjectCreate')
                                    <li class="nav-item">
                                        <a href="{{ url('subject/create') }}" class="nav-link @yield('add_subject')">
                                            <i class="nav-icon bi bi-circle"></i>
                                            <p>Add Subject</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('SubjectAccess')
                                <li class="nav-item">
                                    <a href="{{ url('subject') }}" class="nav-link @yield('manage_subject')">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Manage Subject</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                </ul>
            </li>

            <li class="nav-item @yield('teacher_mo')">
                <a href="#" class="nav-link @yield('teacher')">
                    <i class="nav-icon fas fa-user-tie"></i>
                    <p>
                        Teacher
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('TeacherCreate')
                        <li class="nav-item">
                            <a href="{{ url('teacher-create') }}" class="nav-link @yield('add_teacher')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Add Teacher</p>
                            </a>
                        </li>
                    @endcan
                    @can('TeacherAccess')
                        <li class="nav-item">
                            <a href="{{ url('teacher') }}" class="nav-link @yield('manage_teacher')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Manage Teacher</p>
                            </a>
                        </li>
                    @endcan
                    @can('TeacherPresenceCreate')
                        <li class="nav-item">
                            <a href="{{ url('teacher_presence/create') }}" class="nav-link @yield('teacher_presence')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Daily Attendance</p>
                            </a>
                        </li>
                    @endcan
                    @can('TeacherPresenceUpdate')
                        <li class="nav-item">
                            <a href="{{ url('teacher_presence') }}" class="nav-link @yield('teacher_manage_attendance')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Manage Attendance</p>
                            </a>
                        </li>
                    @endcan
                    @can('TeacherAttendanceReportAccess')
                        <li class="nav-item">
                            <a href="{{ url('teacher_presence_report') }}" class="nav-link @yield('teacher_presence_report')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Attendance Report</p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>

            <li class="nav-item @yield('employee_mo')">
                <a href="#" class="nav-link @yield('employee')">
                    <i class="nav-icon fa fa-user-secret"></i>
                    <p>
                        Employee
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('EmployeeCreate')
                        <li class="nav-item">
                            <a href="{{ url('employee-create') }}" class="nav-link @yield('add_employee')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Add Employee</p>
                            </a>
                        </li>
                    @endcan
                    @can('EmployeeAccess')
                        <li class="nav-item">
                            <a href="{{ url('employee') }}" class="nav-link @yield('manage_employee')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Manage Employee</p>
                            </a>
                        </li>
                    @endcan
                    @can('EmployeePresenceCreate')
                        <li class="nav-item">
                            <a href="{{ url('employee_presence/create') }}" class="nav-link @yield('employee_presence')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Daily Attendance</p>
                            </a>
                        </li>
                    @endcan
                    @can('EmployeeAccess')
                        <li class="nav-item">
                            <a href="{{ url('employee_presence') }}" class="nav-link @yield('employee_manage_attendance')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Manage Attendance</p>
                            </a>
                        </li>
                    @endcan
                    @can('EmployeeAttendanceReportAccess')
                        <li class="nav-item">
                            <a href="{{ url('employee_presence_report') }}" class="nav-link @yield('employee_presence_report')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Attendance Report</p>
                            </a>
                        </li>
                    @endcan
                </ul>
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
                    @can('StudentCreate')
                        <li class="nav-item">
                            <a href="{{ url('student-create') }}" class="nav-link @yield('add_student')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Admit Student</p>
                            </a>
                        </li>
                    @endcan
                    @can('StudentAccess')
                        <li class="nav-item">
                            <a href="{{ url('student') }}" class="nav-link @yield('manage_student')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Manage Student</p>
                            </a>
                        </li>
                    @endcan
                    @can('StudentPromotion')
                        <li class="nav-item">
                            <a href="{{ url('promotion-select') }}" class="nav-link @yield('promotion')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Student Promotion</p>
                            </a>
                        </li>
                    @endcan
                    @can('StudentAttendance')
                        <li class="nav-item">
                            <a href="{{ url('student-attendance-select') }}" class="nav-link @yield('student_attendance')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Daily Attendance</p>
                            </a>
                        </li>
                    @endcan
                    @can('StudentAttendance')
                        <li class="nav-item">
                            <a href="{{ url('student-attendance-edit-select') }}" class="nav-link @yield('student_attendance_edit')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Modify Attendance</p>
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

            <li class="nav-item @yield('guardian_mo')">
                <a href="#" class="nav-link @yield('guardian')">
                    <i class="nav-icon fa fa-user"></i>
                    <p>
                        Guardian
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('GuardianAccess')
                        <li class="nav-item">
                            <a href="{{ url('guardian-list') }}" class="nav-link @yield('manage_guardian')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Manage Guardian</p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>

            <li class="nav-item @yield('attendant_mo')">
                <a href="#" class="nav-link @yield('attendant')">
                    <i class="nav-icon fa fa-user-circle"></i>
                    <p>
                        Attendant
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('ManageAttendant')
                        <li class="nav-item">
                            <a href="{{ url('attendant/create') }}" class="nav-link @yield('add_attendant')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Create Attendant</p>
                            </a>
                        </li>
                    @endcan
                    @can('ManageAttendant')
                        <li class="nav-item">
                            <a href="{{ url('attendant') }}" class="nav-link @yield('manage_attendant')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Manage Attendant</p>
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
                    @can('ClassRoutineAccess')
                        <li class="nav-item">
                            <a href="{{ url('class-routine-select') }}" class="nav-link @yield('class_timetable')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Create/Modify Routine</p>
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
                    @can('ManageLeaveType')
                        <li class="nav-item">
                            <a href="{{ url('leave-type') }}" class="nav-link @yield('list_leavetype')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Manage Leave Type</p>
                            </a>
                        </li>
                    @endcan
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
                    @can('CreateNotice')
                        <li class="nav-item">
                            <a href="{{ url('notice/create') }}" class="nav-link @yield('add_notice')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Add Notice</p>
                            </a>
                        </li>
                    @endcan
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

            <li class="nav-item @yield('exam_mo')">
                <a href="#" class="nav-link @yield('exam')">
                    <i class="nav-icon fa fa-graduation-cap"></i>
                    <p>
                        Exam & Marks
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('ManageGradingSystem')
                        <li class="nav-item">
                            <a href="{{ url('grading') }}" class="nav-link @yield('grading')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Manage Grading System</p>
                            </a>
                        </li>
                    @endcan
                    @can('ManageExamType')
                        <li class="nav-item">
                            <a href="{{ url('exam-type') }}" class="nav-link @yield('examtype')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Manage Exam Type</p>
                            </a>
                        </li>
                    @endcan
                    @can('ManageExamMarks')
                        <li class="nav-item">
                            <a href="{{ url('exam-manage-marks') }}" class="nav-link @yield('manage_marks')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Input/Modify Marks</p>
                            </a>
                        </li>
                    @endcan
                    @can('ManageExamMarksCheck')
                        <li class="nav-item">
                            <a href="{{ url('exam-marks-check') }}" class="nav-link @yield('manage_marks_check')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Input Marks Check</p>
                            </a>
                        </li>
                    @endcan
                    @canany(['ManageExamReport','Visitor'])
                        <li class="nav-item">
                            <a href="{{ url('exam-report') }}" class="nav-link @yield('manage_exam_report')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Exam Report</p>
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
                    @can('ManageEvents')
                        <li class="nav-item">
                            <a href="{{ url('event-holiday') }}" class="nav-link @yield('manage_event')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Manage Events & Holidays</p>
                            </a>
                        </li>
                    @endcan
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

            <li class="nav-item @yield('accounting_mo')">
                <a href="#" class="nav-link @yield('accounting')">
                    <i class="nav-icon fa fa-calculator"></i>
                    <p>
                        Accounting
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('AccountingSfees')
                        <li class="nav-item">
                            <a href="{{ url('sFee') }}" class="nav-link @yield('manage_sFee')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Manage Fees</p>
                            </a>
                        </li>
                    @endcan
                    @can('AssignSfees')
                        <li class="nav-item">
                            <a href="{{ url('assign-fees') }}" class="nav-link @yield('assign_sFee')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Assign Fees</p>
                            </a>
                        </li>
                    @endcan
                    @can('ManageAssignSfees')
                        <li class="nav-item">
                            <a href="{{ url('manage-assign-fees') }}" class="nav-link @yield('manage_assign_sFee')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Manage Assign Fees</p>
                            </a>
                        </li>
                    @endcan
                    @can('ManageExpenseType')
                        <li class="nav-item">
                            <a href="{{ url('expense-type') }}" class="nav-link @yield('manage_expense_type')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Manage Expense Type</p>
                            </a>
                        </li>
                    @endcan
                    @can('ManageExpense')
                        <li class="nav-item">
                            <a href="{{ url('expense') }}" class="nav-link @yield('manage_expense')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Manage Expense</p>
                            </a>
                        </li>
                    @endcan
                    @can('ExpenseBalanceReport')
                        <li class="nav-item">
                            <a href="{{ url('balance-report-daterange') }}" class="nav-link @yield('balance_report')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Balance Report</p>
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
                    @can('TransportInfo')
                        <li class="nav-item">
                            <a href="{{ url('transport') }}" class="nav-link @yield('manage_transport')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Manage Transport</p>
                            </a>
                        </li>
                    @endcan
                    @can('TransportRegistration')
                        <li class="nav-item">
                            <a href="{{ url('transport-registration') }}" class="nav-link @yield('manage_transport_registration')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Manage Transport Registration</p>
                            </a>
                        </li>
                    @endcan
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
                    @can('SubjectClassMapping')
                    <li class="nav-item">
                        <a href="{{ url('subject-class-mapping') }}" class="nav-link @yield('manage_subject_class_mapping')">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Subject Class Mapping</p>
                        </a>
                    </li>
                    @endcan
                    @can('SubjectClassExamCriteriaMapping')
                    <li class="nav-item">
                        <a href="{{ url('subject-class-exam-criteria') }}" class="nav-link @yield('manage_subject_class_examCriteria_mapping')">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Subject Class Exam Criteria Mapping</p>
                        </a>
                    </li>
                    @endcan
                    @can('ShiftManagement')
                    <li class="nav-item">
                        <a href="{{ url('shift') }}" class="nav-link @yield('manage_shift')">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Shift Management</p>
                        </a>
                    </li>
                    @endcan
                    @can('PortfolioTagManagement')
                    <li class="nav-item">
                        <a href="{{ url('portfolio-tag') }}" class="nav-link @yield('manage_portfolio_tag')">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Portfolio Tag</p>
                        </a>
                    </li>
                    @endcan
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
                            <a href="{{ url('exam-criteria') }}" class="nav-link @yield('manage_exam_criteria')">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Exam Criteria</p>
                            </a>
                        </li>
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
