<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamType;
use App\Models\SchoolClass;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\SchoolSection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Models\StudentAcademicHistory;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class AcademicHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get_inserted_rolls(Request $request){
        // dd($request->all());
        if ($request->academic_year_id && $request->school_class_id) {
            $result = DB::table('student_academic_histories')->select('roll')
                ->where('school_class_id', $request->school_class_id)
                ->where('academic_year_id', $request->academic_year_id)
                ->where('school_section_id', $request->school_section_id)
                ->get();
            $data = array();
            foreach ($result as $value) {
                $name = $value->roll;
                array_push($data, $name);
            }
            return response()->json($data);
        }
    }

    public function student_academic_history_update(Request $request)
    {
        abort_if(Gate::denies('StudentAcademicUpdate'), redirect('error'));
        $rules = array(
            'roll' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(array(
                'errors' => $validator->getMessageBag()->toArray()
            ));
        else {

            $data = StudentAcademicHistory::find($request->id);
            $data->school_class_id = $request->class_id;
            $data->school_section_id = $request->section_id;
            $data->academic_year_id = $request->academic_year_id;
            $data->roll = $request->roll;
            $data->save();
            return response()->json($data);
        }
    }

    public function promotion_select()
    {
        $school_classes = SchoolClass::orderBy('numeric_no','asc')->pluck('class_name', 'id');
        $school_sections = SchoolSection::orderBy('priority_no','asc')->pluck('section_name', 'id');
        $academic_years = AcademicYear::orderBy('id','desc')->pluck('title', 'id');
        $sessionAcademicYear = getSessionAcademicYear();
        return view('students.promotion_select', compact('school_classes', 'school_sections', 'academic_years','sessionAcademicYear'));
    }

    public function promotion(Request $request)
    {
        // dd($request);
        $student_null = StudentAcademicHistory::where('school_class_id', $request->school_class_id)
            ->where('school_section_id', $request->school_section_id)
            ->where('academic_year_id', $request->academic_year_id)
            ->count();
        // dd($student_null);
        if ($student_null == 0 || null) {
            \Session::flash('flash_error', 'Students are not admitted in the selected class and section');
            return redirect('promotion-select');
        }
        $exm_typ_count = ExamType::where('school_class_id', $request->school_class_id)->count();
        //  dd($exm_typ_count);
        $exm_typ_count_exam = Exam::query()
            ->where('school_class_id', $request->school_class_id)
            ->where('school_section_id', $request->school_section_id)
            ->where('academic_year_id', $request->academic_year_id)
            ->distinct('exam_type_id')
            ->count('exam_type_id');

        // dd($exm_typ_count_exam);
        if ($exm_typ_count != $exm_typ_count_exam) {
            \Session::flash('flash_error', 'There are '.$exm_typ_count .' Exam types founded, But Marks inputs only '.$exm_typ_count_exam .' ,Please Input all the exam marks' );
            return redirect('promotion-select');
        }

        $marks_null = StudentAcademicHistory::query()
            ->join('exams', 'exams.user_id', '=', 'student_academic_histories.user_id')
            ->where('student_academic_histories.school_class_id', $request->school_class_id)
            ->where('student_academic_histories.school_section_id', $request->school_section_id)
            ->where('student_academic_histories.academic_year_id', $request->academic_year_id)
            ->count();
        // dd($marks_null);
        if ($marks_null == 0 || null) {
            \Session::flash('flash_error', 'Marks not inserted in to the Exam section');
            return redirect('promotion-select');
        }
        $promotion = StudentAcademicHistory::query()
            ->select('student_academic_histories.roll', 'student_academic_histories.user_id', 'users.personnel_id', DB::raw('students.first_name'), DB::raw('students.middle_name'), DB::raw('students.last_name'),
                DB::raw('sum(exams.added_mark) as total_marks'))
            ->join('students', 'students.user_id', '=', 'student_academic_histories.user_id')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->join('exams', 'exams.user_id', '=', 'student_academic_histories.user_id')
            ->where('student_academic_histories.school_class_id', $request->school_class_id)
            ->where('student_academic_histories.school_section_id', $request->school_section_id)
            ->where('student_academic_histories.academic_year_id', $request->academic_year_id)
            ->groupBy('users.personnel_id','student_academic_histories.user_id',DB::raw('roll'),DB::raw('students.first_name'), DB::raw('students.middle_name'), DB::raw('students.last_name'))
            ->orderBy('total_marks', 'desc')
            ->get();
        // dd($a);

        $school_class_id = $request->school_class_id;
        $school_section_id = $request->school_section_id;
        $academic_year_id = $request->academic_year_id;
        $school_classes = SchoolClass::orderBy('numeric_no','asc')->pluck('class_name', 'id');
        $school_sections = SchoolSection::orderBy('priority_no','asc')->pluck('section_name', 'id');
        $academic_years = AcademicYear::orderBy('id','desc')->pluck('title', 'id');
        return view('students.promotion', compact('promotion', 'school_classes', 'school_sections', 'academic_years', 'school_class_id', 'school_section_id', 'academic_year_id'));
    }

    public function promotion_store(Request $request)
    {
        $student_academic_history = StudentAcademicHistory::where('school_class_id', '=', $request->school_class_id_pre)
                                    ->where('school_section_id', '=', $request->school_section_id_pre)
                                    ->where('academic_year_id', '=', $request->academic_year_id_pre)
                                    ->get();

        foreach ($request['user_id'] as $uid) {
            $uid_a[] = $uid;
        }
        $ui_d = $uid_a;
        foreach ($request['school_class_id'] as $kid) {
            $kid_a[] = $kid;
        }
        $ki_d = $kid_a;
        foreach ($request['school_section_id'] as $sid) {
            $sid_a[] = $sid;
        }
        $si_d = $sid_a;
        foreach ($request['roll'] as $rn) {
            $rn_a[] = $rn;
        }
        $r_n = $rn_a;
        foreach ($request['academic_year_id'] as $ay) {
            $ay_a[] = $ay;
        }
        $a_y = $ay_a;

        $count_ids = count($ki_d);
        if (count($si_d) != $count_ids) throw new Exception("Bad Request Input Array lengths");
        for ($i = 0; $i < $count_ids; $i++) {
            if (empty($ki_d[$i])) continue; // skip all the blank ones
            $student = new StudentAcademicHistory();
            $student->user_id = $ui_d[$i];
            $student->school_class_id = $ki_d[$i];
            $student->school_section_id = $si_d[$i];
            $student->roll = $r_n[$i];
            $student->academic_year_id = $a_y[$i];
            $student->save();
        }
        return redirect('student');
    }

}
