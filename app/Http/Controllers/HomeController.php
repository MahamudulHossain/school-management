<?php

namespace App\Http\Controllers;

use DB;
use Config;
use Carbon\Carbon;
use App\Models\Notice;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\AcademicYear;
use App\Models\EventHoliday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['clear_all', 'cache_clear', 'config_clear', 'view_clear', 'view_cache',
            'route_clear', 'config_cache', 'route_cache', 'storage_link', 'backupDatabase', 'error', 'fallback']]);
    }

    public function switchLang($lang)
    {
//        dd($lang);
        if (array_key_exists($lang, Config::get('languages'))) {
            \Session::put('applocale', $lang);
//        dd($lang);
            \Session::flash('flash_success', trans('all_settings.language_changedmsg'));

        }
        return Redirect::back();
    }

    public function switchAcadYear($year)
    {
        session()->put('acad_year', $year);
        return redirect()->back();
    }

    public function home()
    {
        $user = Auth::user();

        $totalStudents = Student::where('status','active')->count();
        $totalTeachers = Teacher::where('status','active')->count();
        $totalEmployees = Employee::where('status','active')->count();

        // Common dashboard functions
        if(session()->get('acad_year') != 'all'){
            $notice = Notice::whereYear('created_at', session()->get('acad_year'))->orderBy('created_at', 'desc')->get()->take(15);
        }else{
            $notice = Notice::orderBy('created_at', 'desc')->get()->take(15);
        }

        if (in_array($user->user_type_id,[1,6])) {
            if(session()->get('acad_year') != 'all')
                $currentAcademicYearId = AcademicYear::where('title',session()->get('acad_year'))->first()->id;
            else
                $currentAcademicYearId = AcademicYear::pluck('id')->toArray();
            $newAdmissionCount = $this->newAdmissionCount($currentAcademicYearId);
            $genderWiseNewAdmission = $this->calculateGenderWiseStudent($currentAcademicYearId);
            $userTitle = $user->user_type_id == 1 ? 'Admin' : 'Visitor';

            return view('dashboard.admin',compact('notice','totalStudents','totalTeachers','totalEmployees','newAdmissionCount','genderWiseNewAdmission','userTitle'));
        }elseif($user->user_type_id == 2){
            $currentMonthAttendance = $this->currentMonthAttendance($user);
            return view('dashboard.student',compact('notice','currentMonthAttendance'));
        }elseif($user->user_type_id == 3){
            return view('dashboard.teacher',compact('notice'));
        }elseif($user->user_type_id == 4){
            return view('dashboard.employee',compact('notice'));
        }elseif($user->user_type_id == 5){
            $currentMonthAttendanceInfo = $this->currentMonthAttendance($user);
            $colors = ['primary','success','warning','danger'];
            $icons = ['calendar3','bookmark-fill','gear-fill','hand-thumbs-up'];
            return view('dashboard.guardian',compact('notice','currentMonthAttendanceInfo','colors','icons'));
        }else {
            return view('dashboard.user');
        }
    }

    private function newAdmissionCount($currentAcademicYearId){
        $newAdmittedUserIds = DB::table('student_academic_histories')
                            ->join('students','students.user_id','=','student_academic_histories.user_id')
                            ->where('students.status', 'active')
                            ->select('student_academic_histories.user_id')
                            ->groupBy('student_academic_histories.user_id')
                            ->havingRaw('COUNT(student_academic_histories.user_id) = 1')
                            ->pluck('student_academic_histories.user_id');

        $newAdmissionCount = DB::table('student_academic_histories')
                    ->join('school_classes', 'school_classes.id', '=', 'student_academic_histories.school_class_id')
                    ->select(
                        DB::raw('academic_year_id'),
                        DB::raw('school_classes.class_name'),
                        DB::raw('count(student_academic_histories.user_id) as TotalNewAdmission')
                    );

                    if(session()->get('acad_year') != 'all')
                        $newAdmissionCount = $newAdmissionCount->where('academic_year_id', $currentAcademicYearId);
                    else
                        $newAdmissionCount = $newAdmissionCount->whereIn('academic_year_id', $currentAcademicYearId);

        $newAdmissionCount = $newAdmissionCount->whereIn('user_id', $newAdmittedUserIds)
                    ->groupBy('academic_year_id', 'school_classes.class_name', 'school_class_id')
                    ->orderBy('school_class_id', 'asc')
                    ->get();
        return $newAdmissionCount;
    }

    private function calculateGenderWiseStudent($currentAcademicYearId){

        $base = DB::table('student_academic_histories')
        ->join('students','students.user_id','=','student_academic_histories.user_id')
        ->join('profiles','profiles.user_id','=','student_academic_histories.user_id');
        if(session()->get('acad_year') != 'all')
            $base = $base->where('student_academic_histories.academic_year_id', $currentAcademicYearId);
        else
            $base = $base->whereIn('student_academic_histories.academic_year_id', $currentAcademicYearId);

        $base = $base->where('students.status', 'active');

        $chart_doughnut['male'] = (clone $base)->where('profiles.gender', 'Male')->count();
        $chart_doughnut['female'] = (clone $base)->where('profiles.gender', 'Female')->count();
        $chart_doughnut['other'] = (clone $base)->where('profiles.gender', 'Others')->count();

        return $chart_doughnut;
    }

    private function currentMonthAttendance($user){
        $cMonth = date('m');
        $from = date('Y').'-'.date('m').'-00';
        $to = date('Y').'-'.date('m').'-31';
        if($user->user_type_id == 2){ // Student
            $base = Attendance::whereHas('student',function($query) use ($user){
                    $query->where('user_id',$user->id);
                })
                ->with('student')
                ->whereBetween('date',[$from,$to]);
            $attendance['present'] = (clone $base)->where('attendance','Present')->count();
            $attendance['total_days'] = (clone $base)->count();
            return $attendance;
        }else{ // Guardian
            $attendanceInfo = [];
            $children = getChildInfo();
            foreach($children as $child){
                $userIds[] = $child->user_id;
            }
            $baseArray = Attendance::whereHas('student',function($query) use ($userIds){
                    $query->whereIn('user_id',$userIds);
            })
            ->with('student')
            ->whereBetween('date',[$from,$to]);

            foreach($userIds as $userId){
                $student = (clone $baseArray)->whereHas('student',function($query2) use ($userId){
                                    $query2->where('user_id',$userId);
                            })->get();
                            // dd($student);
                if(count($student)>0){
                    $arr['name'] = $student[0]?->student->first_name.' '.$student[0]?->student->middle_name.' '.$student[0]?->student->last_name;
                    $arr['present'] = $student->where('attendance','Present')->count();
                    $arr['total_days'] = $student->count();
                    array_push($attendanceInfo,$arr);
                }
            }
            return $attendanceInfo;
        }
    }

}
