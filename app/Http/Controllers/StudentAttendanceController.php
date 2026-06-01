<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\SchoolSection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\StudentAcademicHistory;

class StudentAttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function student_attendance_select(){
        abort_if(Gate::denies('StudentAttendance'), redirect('error'));
        $school_classes = SchoolClass::orderBy('numeric_no','asc')->pluck('class_name', 'id');
        $school_sections = SchoolSection::orderBy('priority_no','asc')->pluck('section_name', 'id');
        $academic_years = AcademicYear::orderBy('id','desc')->pluck('title', 'id');
        $sessionAcademicYear = getSessionAcademicYear();
        return view('attendance.attendance_select', compact('school_classes', 'school_sections','academic_years','sessionAcademicYear'));
    }

    public function student_attendance_edit_select(){
        abort_if(Gate::denies('StudentAttendance'), redirect('error'));
        $school_classes = SchoolClass::orderBy('numeric_no','asc')->pluck('class_name', 'id');
        $school_sections = SchoolSection::orderBy('priority_no','asc')->pluck('section_name', 'id');
        $academic_years = AcademicYear::orderBy('id','desc')->pluck('title', 'id');
        $sessionAcademicYear = getSessionAcademicYear();
        return view('attendance.attendance_edit_select', compact('school_classes', 'school_sections','academic_years','sessionAcademicYear'));
    }

    public function create(Request $request){
        $this->validate($request, [
            'date' => 'required|date',
        ]);
        $k_id=$request->school_class_id;
        $s_id=$request->school_section_id;
        $date=date('Y-m-d', strtotime($request->date));
        $academic_year_id=$request->academic_year_id;

        $dateExists = Attendance::where('school_class_id', $k_id)
            ->where('school_section_id', $s_id)
            ->where('academic_year_id', $academic_year_id)
            ->where('date', $date)
            ->exists();
        if($dateExists){
            \Session::flash('flash_error','Attendance already been inserted on selected date,You can Modify only');
            return redirect('student-attendance-select');
        }

        $student = StudentAcademicHistory::orderBy('roll')
            ->where('school_class_id',$k_id)
            ->where('academic_year_id',$academic_year_id)
            ->where('school_section_id',$s_id)
            ->get();

        $schoolClass = SchoolClass::find($k_id);
        $schoolSection = SchoolSection::find($s_id);
        $academicYear = AcademicYear::find($academic_year_id);

        return view('attendance.attendancebyclass', compact('student', 'k_id', 's_id', 'schoolClass','schoolSection','date','academic_year_id','academicYear'));
    }

    public function store(Request $request)
    {
        foreach ($request['student_id'] as $index => $studentId) {
            // Skip if student_id is empty
            if (empty($studentId)) continue;

            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'school_class_id' => $request->school_class_id,
                    'school_section_id' => $request->school_section_id,
                    'academic_year_id' => $request->academic_year_id,
                    'date' => date('Y-m-d', strtotime($request->date))
                ],
                [
                    'attendance' => $request['attendance'][$index],
                    'roll' => $request['roll'][$index],
                    'attendance_by' => Auth::user()->id
                ]
            );
        }
        \Session::flash('flash_message','Attendance Successfully Added');
        return redirect('student-attendance-select');
    }

    public function student_attendance_editByClass(Request $request){
        $k_id=$request->school_class_id;
        $s_id=$request->school_section_id;
        $date=date('Y-m-d', strtotime($request->date));
        $academic_year_id=$request->academic_year_id;

        $attendance = Attendance::where('school_class_id', $k_id)
            ->where('school_section_id', $s_id)
            ->where('academic_year_id', $academic_year_id)
            ->where('date', $date)
            ->get();
        if(! $attendance){
            \Session::flash('flash_error','Attendance not inserted yet on selected date.');
            return redirect('student-attendance-select');
        }
        $schoolClass = SchoolClass::find($k_id);
        $schoolSection = SchoolSection::find($s_id);
        $academicYear = AcademicYear::find($academic_year_id);
        return view('attendance.attendanceEditByClass', compact('attendance', 'k_id', 's_id', 'schoolClass','schoolSection','date','academic_year_id','academicYear'));
    }

    public function student_attendance_updateByClass(Request $request){
        // dd($request->all());
        foreach ($request['student_id'] as $index => $studentId) {
            // Skip if student_id is empty
            if (empty($studentId)) continue;

            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'school_class_id' => $request->school_class_id,
                    'school_section_id' => $request->school_section_id,
                    'academic_year_id' => $request->academic_year_id,
                    'date' => date('Y-m-d', strtotime($request->date))
                ],
                [
                    'attendance' => $request['attendance'][$index],
                    'roll' => $request['roll'][$index],
                    'attendance_by' => Auth::user()->id
                ]
            );
        }
        \Session::flash('flash_message','Attendance Successfully Added');
        return redirect('student-attendance-select');
    }

    public function student_attendance_report(){
        abort_if(Gate::denies('StudentAttendanceReportAccess'), redirect('error'));
        $school_classes = SchoolClass::pluck('class_name', 'id');
        $school_sections = SchoolSection::orderBy('priority_no','asc')->pluck('section_name', 'id');
        return view('attendance.student_attendance_report', compact('school_classes','school_sections'));
    }

    public function student_attendance_reportbyrange(Request $request){
        $this->validate($request, [
            'school_class_id' => 'required',
            'school_section_id' => 'required',
            'date_range' => 'required',
        ]);
        [$from, $to] = explode(' - ', $request->date_range);
        if(in_array(Auth::user()->user_type_id,[2,5])){
            $auth = Auth::user();

            if(Auth::user()->user_type_id == 2){ // Student
                $attendance_students = Attendance::whereHas('student',function($query) use ($auth){
                    $query->where('user_id',$auth->id);
                })
                ->with('student')
                ->where([
                'school_class_id'=>$request->school_class_id,
                'school_section_id'=>$request->school_section_id
                ])->whereBetween('date',[$from,$to])->orderBy('date','desc')->get();
            }else{ //Guardian
                $children = getChildInfo();
                foreach($children as $child){
                    $userIds[] = $child->user_id;
                }

                $attendance_students = Attendance::whereHas('student', function($query) use ($userIds) {
                    $query->whereIn('user_id', $userIds);
                })
                ->with('student')
                ->where([
                    'school_class_id'=>$request->school_class_id,
                    'school_section_id'=>$request->school_section_id
                ])
                ->whereBetween('date',[$from,$to])
                ->orderBy('date','desc')
                ->get();
            }
        }else{
            $attendance_students = Attendance::where([
            'school_class_id'=>$request->school_class_id,
            'school_section_id'=>$request->school_section_id
            ])->whereBetween('date',[$from,$to])->orderBy('date','desc')->get();
        }
// dd($attendance_students);
        return view('attendance.report_datewise', compact('attendance_students'));
    }

    public function attendance_report_bystudent(Request $request){
        $this->validate($request, [
            'school_class_id' => 'required',
            'school_section_id' => 'required',
            'roll' => 'required',
            'date_range' => 'required',
        ]);
        [$from, $to] = explode(' - ', $request->date_range);
        $attendance_student = [];
        if(in_array(Auth::user()->user_type_id,[2,5])){
            $auth = Auth::user();

            if(Auth::user()->user_type_id == 2){ // Student
                $attendance_student = Attendance::whereHas('student',function($query) use ($auth){
                    $query->where('user_id',$auth->id);
                })
                ->with('student')
                ->where([
                'school_class_id'=>$request->school_class_id,
                'school_section_id'=>$request->school_section_id,
                'roll'=>$request->roll,
                ])->whereBetween('date',[$from,$to])->orderBy('date','desc')->get();
            }else{ //Guardian
                $children = getChildInfo();
                foreach($children as $child){
                    $userIds[] = $child->user_id;
                }

                $attendance_student = Attendance::whereHas('student', function($query) use ($userIds) {
                    $query->whereIn('user_id', $userIds);
                })
                ->with('student')
                ->where([
                    'school_class_id'=>$request->school_class_id,
                    'school_section_id'=>$request->school_section_id,
                    'roll'=>$request->roll,
                ])
                ->whereBetween('date',[$from,$to])
                ->orderBy('date','desc')
                ->get();
            }
        }else{
            $attendance_student = Attendance::where([
            'school_class_id'=>$request->school_class_id,
            'school_section_id'=>$request->school_section_id,
            'roll'=>$request->roll,
            ])->whereBetween('date',[$from,$to])->orderBy('date','desc')->get();
        }

        $studentName = count($attendance_student) ? $attendance_student[0]->student->first_name.' '.$attendance_student[0]->student->middle_name.' '.$attendance_student[0]->student->last_name.' ('. $attendance_student[0]->student->user->personnel_id .')' : '';

        return view('attendance.report_bystudent', compact('attendance_student','studentName'));
    }
}
