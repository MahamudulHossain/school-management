<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    AboutUsController,AcademicHistoryController,AccountingTransportController,AssignStudentFeeController,AttendantController,
    CarouselController,ClassRoutineController,EmployeeController,EmployeePresenceController,EventHolidayController,ExamController,
    ExamCriteriaController,ExamTypeController,ExpenseController,ExpenseTypeController,FrontController,GradingController,GuardianController,
    HomeController,ImageProfileController,LeaveTrackController,LeaveTypeController,NoticeController,PermissionController,PortfolioController,
    PortfolioTagController,ProfileController,RoleController,SettingController,ShiftController,StudentAccountsController,
    StudentAttendanceController,StudentController,SubjectClassMappingController,SubjectClassExamCriteriaMappingController,TeacherController,
    TeacherPresenceController,TransportController,TransportRegistrationController,UserController,UserTypeController
};

use App\Http\Controllers\Academic\{
    AcademicYearController,SchoolClassController,SchoolSectionController,SubjectController,TermController
};

Route::get('/', [FrontController::class, 'front']);
Route::get('/get-events', [FrontController::class, 'getEvents'])->name('get.events');

require __DIR__.'/auth.php';


Route::middleware(['web', 'auth'])->group(function () {
    Route::middleware([\App\Http\Middleware\AuthGates::class])->group(function () {
        Route::get('switchAcadYear/{year}', [HomeController::class, 'switchAcadYear'])->name('acadYearSwitch');
        Route::get('/home', [HomeController::class, 'home'])->name('home');
        Route::fallback([SettingController::class, 'fallback']);
        Route::get('/error', [SettingController::class, 'error']);
        Route::get('/cache_clear', [SettingController::class, 'cache_clear']);
        Route::get('/config_clear', [SettingController::class, 'config_clear']);
        Route::get('/view_clear', [SettingController::class, 'view_clear']);
        Route::get('/route_clear', [SettingController::class, 'route_clear']);
        Route::get('/clear_all', [SettingController::class, 'clear_all']);
        Route::get('/storage_link', [SettingController::class, 'storage_link']);
        Route::get('/backupDatabase{code}', [SettingController::class, 'backupDatabase']);

        Route::get('lang/{lang}', [HomeController::class, 'switchLang'])->name('lang.switch');
        Route::get('dashboard', [HomeController::class, 'home'])->name('dashboard');
        Route::resource('permission', PermissionController::class);
        Route::resource('role', RoleController::class);
        Route::resource('user-type', UserTypeController::class);
        Route::resource('setting', SettingController::class);
        Route::resource('shift', ShiftController::class)->except(['create','store']);
        Route::post('/select_user_action', [UserController::class, 'select_user_action'])->name('select_user_action');
        Route::patch('/user/Auth::user()', [UserController::class, 'password_update'])->name('password_update');
        Route::get('/myprofile', [UserController::class, 'myprofile'])->name('myprofile');
        Route::resource('user', UserController::class);
        Route::resource('profile', ProfileController::class);
        Route::resource('imageprofile', ImageProfileController::class);
        // Basic CRUD
        Route::resource('schoolClass', SchoolClassController::class);
        Route::resource('schoolSection', SchoolSectionController::class);
        Route::resource('academicYear', AcademicYearController::class);
        Route::resource('term', TermController::class);
        Route::resource('subject', SubjectController::class);
        Route::resource('subject-class-mapping', SubjectClassMappingController::class)->except(['show','destroy']);
        Route::resource('exam-criteria', ExamCriteriaController::class)->except(['show']);
        Route::resource('subject-class-exam-criteria', SubjectClassExamCriteriaMappingController::class)->only(['index','create','store']);

        // Additional Routes for SubjectClassExamCriteriaMapping
        Route::get('subject-class-exam-criteria/{school_class_id}/{subject_id}/edit', [SubjectClassExamCriteriaMappingController::class, 'edit'])->name('subject-class-exam-criteria.edit');
        Route::put('subject-class-exam-criteria/{school_class_id}/{subject_id}', [SubjectClassExamCriteriaMappingController::class, 'update'])->name('subject-class-exam-criteria.update');
        Route::get('subject-class-exam-criteria/{school_class_id}/{subject_id}', [SubjectClassExamCriteriaMappingController::class, 'delete'])->name('subject-class-exam-criteria.destroy');

        // ajax
        Route::get('get-subjects-by-class/{class_id}', [SubjectClassMappingController::class, 'get_subjects_by_class'])->name('get-subjects-by-class');
        Route::get('getExamCriteriaClassSubject', [SubjectClassExamCriteriaMappingController::class, 'get_exam_criteria_by_class_subject'])->name('getExamCriteriaClassSubject');

        // Teacher
        Route::get('teacher', [TeacherController::class, 'index'])->name('teacher-index');
        Route::get('teacher-create', [UserController::class, 'teacher_create'])->name('teacher-create');
        Route::patch('/teacher_personal_profile/{id}', [TeacherController::class, 'personal_profile_update'])->name('teacher.personal_profile.update');
        Route::resource('teacher_presence', TeacherPresenceController::class)
                ->parameters(['teacher_presence' => 'date']);
        Route::get('teacher_presence_report', [TeacherPresenceController::class, 'teacher_presence_report'])->name('teacher_presence.report');
        Route::post('teacher_attendance_reportbyrange', [TeacherPresenceController::class, 'teacher_attendance_reportbyrange'])->name('teacher_attendance.reportbyrange');
        Route::post('attendance_report_byteacher', [TeacherPresenceController::class, 'attendance_report_byteacher'])->name('attendance_report.byteacher');
        // Employee
        Route::get('employee', [EmployeeController::class, 'index'])->name('employee-index');
        Route::get('employee-create', [UserController::class, 'employee_create'])->name('employee-create');
        Route::patch('/employee_personal_profile/{id}', [EmployeeController::class, 'personal_profile_update'])->name('employee.personal_profile.update');
        Route::resource('employee_presence', EmployeePresenceController::class)
                ->parameters(['employee_presence' => 'date']);
        Route::get('employee_presence_report', [EmployeePresenceController::class, 'employee_presence_report'])->name('employee_presence.report');
        Route::post('employee_attendance_reportbyrange', [EmployeePresenceController::class, 'employee_attendance_reportbyrange'])->name('employee_attendance.reportbyrange');
        Route::post('attendance_report_byemployee', [EmployeePresenceController::class, 'attendance_report_byemployee'])->name('attendance_report.byemployee');
        // Student
        Route::get('student', [StudentController::class, 'index'])->name('student-index');
        Route::get('student-create', [UserController::class, 'student_create'])->name('student-create');
        Route::post('get-inserted-rolls', [AcademicHistoryController::class, 'get_inserted_rolls'])->name('get-inserted-rolls');
        Route::patch('/student_personal_profile/{id}', [StudentController::class, 'personal_profile_update'])->name('student.personal_profile.update');
        Route::patch('/student_guardian_profile/{id}', [StudentController::class, 'guardian_profile_update'])->name('student.guardian_profile.update');
        Route::patch('/student_attendant_profile/{id}', [StudentController::class, 'attendant_profile_update'])->name('student.attendant_profile.update');
        Route::post('student_academic_history_update', [AcademicHistoryController::class, 'student_academic_history_update'])->name('student.academic_history_update');
        Route::get('promotion-select', [AcademicHistoryController::class, 'promotion_select'])->name('promotion-select');
        Route::get('promotion', [AcademicHistoryController::class, 'promotion'])->name('promotion');
        Route::post('promotion-store', [AcademicHistoryController::class, 'promotion_store'])->name('promotion-store');
        Route::get('student-attendance-select', [StudentAttendanceController::class, 'student_attendance_select'])->name('student-attendance-select');
        Route::get('student-attendance-edit-select', [StudentAttendanceController::class, 'student_attendance_edit_select'])->name('student-attendance-edit-select');
        Route::get('student-attendance-editByClass', [StudentAttendanceController::class, 'student_attendance_editByClass'])->name('student-attendance.editByClass');
        Route::post('student-attendance-updateByClass', [StudentAttendanceController::class, 'student_attendance_updateByClass'])->name('student-attendance.updateByClass');
        Route::resource('attendance', StudentAttendanceController::class)->except(['edit', 'update']);
        Route::get('student-attendance-report', [StudentAttendanceController::class, 'student_attendance_report'])->name('student_attendance.report');
        Route::post('student-attendance-reportbyrange', [StudentAttendanceController::class, 'student_attendance_reportbyrange'])->name('student-attendance.reportbyrange');
        Route::post('attendance-report-bystudent', [StudentAttendanceController::class, 'attendance_report_bystudent'])->name('attendance-report.bystudent');

        // Guardian
        Route::get('guardian-list', [GuardianController::class, 'guardian_list']);
        Route::patch('/guardian_personal_profile/{id}', [GuardianController::class, 'personal_profile_update'])->name('guardian.personal_profile.update');
        // Attendant
        Route::resource('attendant', AttendantController::class);
        Route::get('attached-list/{attendant_id}', [AttendantController::class, 'attached_list']);

        // Leave
        Route::resource('leave-type', LeaveTypeController::class);
        Route::post('leave-track/auto_user_leave', [LeaveTrackController::class, 'auto_user_leave']);
        Route::post('leave-track/{id}/auto_user_leave', [LeaveTrackController::class, 'auto_user_leave']);
        Route::resource('leave-track', LeaveTrackController::class);

        // Notice
        Route::resource('notice', NoticeController::class);

        // Events & Holidays
        Route::get('event-calendar', [EventHolidayController::class, 'event_calendar'])->name('event.calendar');
        Route::get('events', [EventHolidayController::class, 'getEvents']);
        Route::resource('event-holiday', EventHolidayController::class);

        // Exam and Marks
        Route::resource('grading', GradingController::class);
        Route::resource('exam-type', ExamTypeController::class);
        Route::get('exam-manage-marks', [ExamController::class, 'exam_manage_marks'])->name('exam-manage-marks');
        Route::post('selectajax_exam', [ExamController::class, 'selectajax_exam'])->name('selectajax_exam');
        Route::get('input-exam-marks', [ExamController::class, 'input_exam_marks'])->name('input-exam-marks');
        Route::post('input-exam-marks', [ExamController::class, 'store'])->name('exam.input_exam_marks');
        Route::get('exam-marks-check', [ExamController::class, 'exam_marks_check'])->name('exam-marks-check');
        Route::get('exam-marks-check-view', [ExamController::class, 'exam_marks_check_view'])->name('exam-marks-check-view');
        Route::get('exam-report', [ExamController::class, 'exam_report'])->name('exam-report');
        Route::get('exam-report-class-term', [ExamController::class, 'exam_report_class_term'])->name('exam-report-class-term');
        Route::get('exam-report-class-subject', [ExamController::class, 'exam_report_class_subject'])->name('exam-report-class-subject');
        // Route::get('exam-report-class-student', [ExamController::class, 'exam_report_class_student'])->name('exam-report-class-student');
        Route::get('exam-report-class-student', [ExamController::class, 'exam_report_class_student_2'])->name('exam-report-class-student');

        // Accounts
        Route::resource('sFee', StudentAccountsController::class);
        Route::get('assign-fees', [AssignStudentFeeController::class, 'assign_fees'])->name('assign-fees');
        Route::post('selectajax_feeType', [AssignStudentFeeController::class, 'selectajax_feeType'])->name('selectajax_feeType');
        Route::get('fetch-students-info', [AssignStudentFeeController::class, 'create'])->name('fetch-students-info');
        Route::post('assign-fees', [AssignStudentFeeController::class, 'store'])->name('store.assign-fees');
        Route::get('manage-assign-fees', [AssignStudentFeeController::class, 'manage_assign_fees'])->name('manage-assign-fees');
        Route::delete('delete-assign-fees/{id}', [AssignStudentFeeController::class, 'destroy'])->name('destroy.assign-fees');
        Route::get('assign-fees/{id}/edit', [AssignStudentFeeController::class, 'edit'])->name('assign-fees.edit');
        Route::post('update-assign-fees', [AssignStudentFeeController::class, 'update'])->name('update.assign-fees');
        Route::resource('expense-type', ExpenseTypeController::class);
        Route::resource('expense', ExpenseController::class);
        Route::get('balance-report-daterange', [ExpenseController::class, 'balance_report_daterange'])->name('balance-report-daterange');
        Route::get('accounting-balance-report', [ExpenseController::class, 'accounting_balance_report'])->name('accounting-balance-report');

        // Transport
        Route::resource('transport', TransportController::class);
        Route::resource('transport-registration', TransportRegistrationController::class);
        Route::post('auto_student_transport', [TransportRegistrationController::class, 'auto_student_transport']);
        Route::resource('accounting-transport', AccountingTransportController::class);
        Route::get('assign-transportfee', [AccountingTransportController::class, 'assign_transportfee'])->name('assign-transportfee');

        // Class Timetable
        Route::get('class-routine-select', [ClassRoutineController::class, 'class_routine_select'])->name('class-routine-select');
        Route::post('/routine/check-teacher-availability', [ClassRoutineController::class, 'checkTeacherAvailability'])->name('check.teacher.availability');
        Route::resource('class-routine', ClassRoutineController::class)->except(['distroy','show']);
        Route::get('/class-routine/view', [ClassRoutineController::class, 'view'])->name('class-routine.view');
        Route::delete('/class-routine/delete', [ClassRoutineController::class, 'destroy'])->name('class-routine.destroy');

        // Front settings
        Route::resource('carousel', CarouselController::class);
        Route::resource('about-us', AboutUsController::class)->except(['create', 'store', 'show', 'destroy']);
        Route::resource('portfolio-tag', PortfolioTagController::class)->except(['show','destroy']);
        Route::resource('portfolio', PortfolioController::class)->except(['show']);


    });
});


