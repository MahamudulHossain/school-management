<?php

use Carbon\Carbon;
use App\Models\Student;
use App\Models\Guardian;
use App\Models\SchoolClass;
use App\Models\ShiftPeriod;
use App\Models\AcademicYear;
use App\Models\ClassRoutine;
use App\Models\SchoolSection;
use App\Models\StudentGuardian;
use Illuminate\Support\Facades\Auth;

function acadYearInfo($yearId)
{
    $bh = AcademicYear::where('title', $yearId)->first();
    if ($bh == null)
        return 'N/A';
    else
        return $bh;
}

function getChildInfo(){
    $guardian = Guardian::where('user_id',Auth::user()->id)->first();
    $children = StudentGuardian::where('guardian_id',$guardian->id)->get();
    foreach($children as $st){
        $studentInfo[] = Student::where('id',$st->student_id)->first();
    }
    return $studentInfo;
}

function routine($school_class_id,$school_section_id,$academic_year_id)
    {
        $data['school_class'] = SchoolClass::findOrFail($school_class_id);
        $data['school_section'] = SchoolSection::findOrFail($school_section_id);
        $data['year'] = AcademicYear::findOrFail($academic_year_id);
        $getshift = ClassRoutine::where([
            'school_class_id' => $school_class_id,
            'school_section_id' => $school_section_id,
            'academic_year_id' => $academic_year_id,
        ])->get();
        if(count($getshift)>0){
            $shift = $getshift[0]->shift;
        }else{
            $data['routines'] = [];
            return $data;
        }
        $data['daysOfWeek'] = ['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday'];
        $no_of_periods = SchoolClass::find($school_class_id)->number_of_periods ?? 0;
        $data['periods'] = range(1, $no_of_periods);
        $shift_info = ShiftPeriod::where('shift_id',$shift)->get();

        $shiftArr = [];
        $data['tiffin_starts_after'] = 0;
        foreach($shift_info as $key=>$s_info){
            if($s_info->type == 'assembly'){
                $shiftArr['assembly']['title'] = $s_info->title;
                $shiftArr['assembly']['start_time'] = Carbon::parse($s_info->start_time)->format('h:i A');
                $shiftArr['assembly']['end_time'] = Carbon::parse($s_info->end_time)->format('h:i A');
            }else{
                if($s_info->type == 'tiffin')
                    $data['tiffin_starts_after'] = $key - 1;
                $shiftArr[$s_info->period_number]['title'] = $s_info->title;
                $shiftArr[$s_info->period_number]['start_time'] = Carbon::parse($s_info->start_time)->format('h:i A');
                $shiftArr[$s_info->period_number]['end_time'] = Carbon::parse($s_info->end_time)->format('h:i A');
            }
        }
        $data['shiftArr'] = $shiftArr;
        // dd($tiffin_starts_after);
        // Fetch all routines for this combination
        $data['routines'] = ClassRoutine::with(['subject:id,subject_name', 'teacher:id,first_name,last_name'])
                    ->where([
                        'school_class_id' => $school_class_id,
                        'school_section_id' => $school_section_id,
                        'academic_year_id' => $academic_year_id,
                        'shift' => $shift,
                    ])
                    ->get();
        $matrix = [];
        foreach ($data['daysOfWeek'] as $day) {
            foreach ($data['periods'] as $p) {
                $matrix[$day][$p] = null;
            }
        }

        foreach ($data['routines'] as $r) {
            $day = $r->day_of_week ?? $r->day ?? null;
            $period = $r->period_number ?? $r->period ?? null;
            // dd($period);
            if ($day && $period) {
                $matrix[$day][$period] = $r;
            }
        }
        // dd($matrix);
        $data['matrix'] = $matrix;

        return $data;
    }

function getSessionAcademicYear()
{
    $academic_year_id = null;
    $academic_year = session('acad_year');
    if ($academic_year != 'all') {
        $academic_year = AcademicYear::where('title', $academic_year)->first();
        if ($academic_year) {
            $academic_year_id = $academic_year->id;
        }
    }
    return $academic_year_id;
}

function sessionAcademicYearWithAll(){
    $academic_year = session('acad_year');
    if ($academic_year != 'all') {
        $academic_year = AcademicYear::where('title', $academic_year)->first();
        if ($academic_year) {
            $academic_year_id = $academic_year->id;
        }
    }else{
        $academic_year_id = AcademicYear::pluck('id')->toArray();
    }
    return $academic_year_id;
}
