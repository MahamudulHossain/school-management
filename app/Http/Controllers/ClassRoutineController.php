<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\ShiftPeriod;
use App\Models\AcademicYear;
use App\Models\ClassRoutine;
use Illuminate\Http\Request;
use App\Models\SchoolSection;
use Illuminate\Support\Facades\Gate;

class ClassRoutineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        abort_if(Gate::denies('ClassRoutineViewAccess'), redirect('error'));
        $academicYearId = sessionAcademicYearWithAll();
        $routines = ClassRoutine::select(
            'school_class_id',
            'school_section_id',
            'shift',
            'academic_year_id'
        );
        if(is_array($academicYearId))
            $routines = $routines->whereIn('academic_year_id',$academicYearId);
        else
            $routines = $routines->where('academic_year_id',$academicYearId);
        $routines = $routines->groupBy('school_class_id', 'school_section_id', 'shift', 'academic_year_id')
        ->with([
            'student_class:id,class_name',
            'student_section:id,section_name',
            'academic_year:id,title',
        ])
        ->orderBy('academic_year_id', 'desc')
        ->get();

    return view('routine.index', compact('routines'));

    }

    public function class_routine_select(){
        abort_if(Gate::denies('ClassRoutineAccess'), redirect('error'));
        $school_classes = SchoolClass::pluck('class_name', 'id');
        $school_sections = SchoolSection::orderBy('priority_no','asc')->pluck('section_name', 'id');
        $academic_years = AcademicYear::pluck('title', 'id');
        $shifts = ['Morning','Day'];
        $sessionAcademicYear = getSessionAcademicYear();
        return view('routine.class_routine_select', compact('school_classes','school_sections','shifts','academic_years','sessionAcademicYear'));
    }

    public function create(Request $request){
        abort_if(Gate::denies('ClassRoutineAccess'), redirect('error'));
        $data = ClassRoutine::where([
            'school_class_id'=>$request->school_class_id,
            'school_section_id'=>$request->school_section_id,
            'shift'=>$request->shift,
            'academic_year_id'=>$request->academic_year_id,
        ])->get();

        $routineData = [];
        if(count($data)){
            foreach ($data as $row) {
                $routineData[$row->day_of_week][$row->period_number] = [
                    'subject_id' => $row->subject_id,
                    'teacher_id' => $row->teacher_id,
                ];
            }
        }

        $school_class_id = $request->school_class_id;
        $school_section_id = $request->school_section_id;
        $shift = $request->shift;
        $academic_year_id = $request->academic_year_id;
        $daysOfWeek = ['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday'];
        $subjects = Subject::all();
        $teachers = Teacher::with('user')
                    ->where('status', 'active')
                    ->get();
        $no_of_periods = SchoolClass::find($school_class_id)->number_of_periods ?? 0;
        $periods = range(1, $no_of_periods);
        return view('routine.create_modify',compact('data','routineData','daysOfWeek','teachers','subjects','periods','school_class_id','school_section_id','shift','academic_year_id'));
    }

    public function checkTeacherAvailability(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'day_of_week' => 'required|string|in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday',
            'period_number' => 'required|integer|min:1|max:8',
            'academic_year_id' => 'required|exists:academic_years,id',
            'shift' => 'required|string',
        ]);

        $isBusy = ClassRoutine::where('teacher_id', $request->teacher_id)
            ->where('day_of_week', $request->day_of_week)
            ->where('period_number', $request->period_number)
            ->where('academic_year_id', $request->academic_year_id)
            ->where('shift', $request->shift)
            ->exists();

        if ($isBusy) {
            return response()->json([
                'available' => false,
                'message' => "Teacher is busy: Already scheduled for Period {$request->period_number} on {$request->day_of_week}."
            ], 409);
        }

        return response()->json([
            'available' => true,
            'message' => 'Teacher is available.'
        ], 200);
    }

    public function store(Request $request){
        // dd($request->all());
        $schoolClassId = $request->school_class_id;
        $sectionId = $request->school_section_id;
        $academicYearId = $request->academic_year_id;
        $shift = $request->shift;

        // Loop through each day and period
        foreach ($request->subject as $day => $periods) {
            foreach ($periods as $periodNumber => $subjectId) {
                $teacherId = $request->teacher[$day][$periodNumber] ?? null;

                if ($subjectId && $teacherId) {
                    ClassRoutine::updateOrCreate(
                        [
                            'school_class_id' => $schoolClassId,
                            'school_section_id' => $sectionId,
                            'academic_year_id' => $academicYearId,
                            'shift' => $shift,
                            'day_of_week' => $day,
                            'period_number' => $periodNumber,
                        ],
                        [
                            'subject_id' => $subjectId,
                            'teacher_id' => $teacherId,
                        ]
                    );
                }
            }
        }
        \Session::flash('flash_success','Class routine created/updated successfully');
        return redirect()->route('class-routine.index');
    }

    public function view(Request $request)
    {
        // Validate query params
        $request->validate([
            'school_class_id' => 'required|integer',
            'school_section_id' => 'required|integer',
            'academic_year_id' => 'required|integer',
            'shift' => 'required',
        ]);

        $school_class = SchoolClass::findOrFail($request->school_class_id);
        $school_section = SchoolSection::findOrFail($request->school_section_id);
        $year = AcademicYear::findOrFail($request->academic_year_id);
        $shift = $request->shift;

        $daysOfWeek = ['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday'];
        $no_of_periods = SchoolClass::find($request->school_class_id)->number_of_periods ?? 0;
        $periods = range(1, $no_of_periods);
        $shift_info = ShiftPeriod::where('shift_id',$request->shift)->get();

        $shiftArr = [];
        $tiffin_starts_after = 0;
        foreach($shift_info as $key=>$s_info){
            if($s_info->type == 'assembly'){
                $shiftArr['assembly']['title'] = $s_info->title;
                $shiftArr['assembly']['start_time'] = Carbon::parse($s_info->start_time)->format('h:i A');
                $shiftArr['assembly']['end_time'] = Carbon::parse($s_info->end_time)->format('h:i A');
            }else{
                if($s_info->type == 'tiffin')
                    $tiffin_starts_after = $key - 1;
                $shiftArr[$s_info->period_number]['title'] = $s_info->title;
                $shiftArr[$s_info->period_number]['start_time'] = Carbon::parse($s_info->start_time)->format('h:i A');
                $shiftArr[$s_info->period_number]['end_time'] = Carbon::parse($s_info->end_time)->format('h:i A');
            }
        }
        // dd($tiffin_starts_after);
        // Fetch all routines for this combination
        $routines = ClassRoutine::with(['subject:id,subject_name', 'teacher:id,first_name,last_name'])
                    ->where([
                        'school_class_id' => $request->school_class_id,
                        'school_section_id' => $request->school_section_id,
                        'academic_year_id' => $request->academic_year_id,
                        'shift' => $request->shift,
                    ])
                    ->get();
        $matrix = [];
        foreach ($daysOfWeek as $day) {
            foreach ($periods as $p) {
                $matrix[$day][$p] = null;
            }
        }

        foreach ($routines as $r) {
            $day = $r->day_of_week ?? $r->day ?? null;
            $period = $r->period_number ?? $r->period ?? null;
            // dd($period);
            if ($day && $period) {
                $matrix[$day][$period] = $r;
            }
        }
        // dd($matrix);

        return view('routine.view', compact('school_class', 'school_section', 'year', 'routines' ,'daysOfWeek', 'periods', 'matrix', 'shift', 'shiftArr','tiffin_starts_after'));
    }


    public function destroy(Request $request)
    {
        ClassRoutine::where([
            'school_class_id' => $request->school_class_id,
            'school_section_id' => $request->school_section_id,
            'academic_year_id' => $request->academic_year_id,
            'shift' => $request->shift,
        ])->delete();
        \Session::flash('flash_success','Class routine deleted successfully');
        return redirect()->route('class-routine.index');
    }
}
