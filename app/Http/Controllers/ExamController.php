<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Grading;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ExamType;
use App\Models\SchoolClass;
use App\Models\AcademicYear;
use App\Models\ExamCriteria;
use Illuminate\Http\Request;
use App\Models\SchoolSection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\StudentAcademicHistory;

class ExamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function exam_manage_marks()
    {
        abort_if(Gate::denies('ManageExamMarks'), redirect('error'));
        $school_classes= DB::table('school_classes')->orderBy('numeric_no','asc')->pluck('class_name','id');
        $school_sections= DB::table('school_sections')->orderBy('priority_no','asc')->pluck('section_name','id');
        $academic_years= DB::table('academic_years')->orderBy('id','desc')->pluck('title','id');
        $examtype_names = DB::table('exam_types')->pluck('examtype_name','id');
        $teacher_names = DB::table('teachers')->pluck('first_name','id');
        return view('exam.exam_manage_marks', compact('school_classes', 'school_sections','academic_years','examtype_names','teacher_names'));
    }
    public function selectajax_exam(Request $request)
    {
        if($request->ajax()){
            $examtype = DB::table('exam_types')->where('school_class_id',$request->school_class_id)->pluck('examtype_name','id');
            $data = '<option value="" disabled selected>Select Exam Type</option>';
            foreach($examtype as $id => $name){
                $data .= '<option value="'.$id.'">'.$name.'</option>';
            }
            return response()->json($data);
        }
    }

    public function input_exam_marks(Request $request)
    {
        abort_if(Gate::denies('ManageExamMarks'), redirect('error'));
        $students = StudentAcademicHistory::join('students', 'student_academic_histories.user_id', '=', 'students.user_id')
                    ->leftJoin('exams', function($join) use ($request) {
                        $join->on('student_academic_histories.user_id', '=', 'exams.user_id')
                            ->where('exams.exam_type_id', '=', $request->exam_type_id);
                    })
                    ->select(
                        'student_academic_histories.user_id',
                        'students.first_name',
                        'students.last_name',
                        'student_academic_histories.roll',
                        'exams.obtain_mark',
                        'exams.added_mark',
                    )
                    ->where('student_academic_histories.school_class_id', $request->school_class_id)
                    ->where('student_academic_histories.school_section_id', $request->school_section_id)
                    ->where('student_academic_histories.academic_year_id', $request->academic_year_id)
                    ->orderBy('student_academic_histories.roll', 'asc')
                    ->get();

        $school_class = SchoolClass::where('id',$request->school_class_id)->first();
        $school_section = SchoolSection::where('id',$request->school_section_id)->first();
        $academic_year = AcademicYear::where('id',$request->academic_year_id)->first();
        $examtype = ExamType::where('id',$request->exam_type_id)->first();
        $examTakenMark = $request->exam_taken_mark;

        return view('exam.input_exam_marks', compact('students','academic_year', 'school_class','school_section','examtype','examTakenMark'));
    }

    public function store(Request $request){
        // dd($request->all());
        abort_if(Gate::denies('ManageExamMarks'), redirect('error'));
        foreach ($request['user_id'] as $sid) {
            $stuid[] = $sid;        }
        foreach ($request['obtain_marks'] as $mcq) {
            $mrk[] = $mcq;         }
        foreach ($request['added_marks'] as $aMrk) {
            $addMrk[] = $aMrk;         }
        foreach ($request['roll'] as $rl) {
            $rls[] = $rl;         }
        $id = $stuid;
        $mcq = $mrk;
        $addMark = $addMrk;
        $rl = $rls;
        $count_ids = count($id);
// dd($id,$mcq,$addMark,$rl,$count_ids);
        if (count($mcq) != $count_ids) throw new Exception("Bad Request Input Array lengths");
        for ($i = 0; $i < $count_ids; $i++) {
            if (empty($id[$i])) continue; // skip all the blank ones
            if ($mcq[$i] == null) continue; // skip all the null ones
            Exam::updateOrCreate(
                [
                    'user_id' => $id[$i],
                    'school_class_id' => $request->school_class_id,
                    'school_section_id' => $request->school_section_id,
                    'subject_id' => $request->subject_id,
                    'exam_type_id' => $request->examtype_id,
                    'academic_year_id' => $request->academic_year_id,
                ],
                [
                    'exam_mark' => (float) $request->examTakenMark,
                    'obtain_mark' => (float) $mcq[$i],
                    'added_mark' => (float) $addMark[$i],
                    'roll' => $rl[$i],
                    'examtype_name'=> $request->examtype_name,
                ]
            );
        }
        \Session::flash('flash_message', 'Exam marks saved successfully.');
        return redirect()->back();
    }

    public function exam_marks_check()
    {
        abort_if(Gate::denies('ManageExamMarksCheck'), redirect('error'));

        $school_classes= DB::table('school_classes')->orderBy('numeric_no','asc')->pluck('class_name','id');
        $school_sections= DB::table('school_sections')->orderBy('priority_no','asc')->pluck('section_name','id');
        $academic_years= DB::table('academic_years')->orderBy('id','desc')->pluck('title','id');
        return view('exam.exam_marks_check', compact('school_classes', 'school_sections','academic_years'));
    }

    public function exam_marks_check_view(Request $request)
    {
        abort_if(Gate::denies('ManageExamMarksCheck'), redirect('error'));
        $mcheck = ExamType::where('school_class_id',$request->school_class_id)
            ->get();
        return view('exam.exam_marks_check_view', compact('mcheck'));
    }

    public function exam_report()
    {
        // abort_if(Gate::denies('ManageExamReport'), redirect('error'));
        abort_if(Gate::none(['ManageExamReport', 'Visitor']), 403, 'Unauthorized');

        $school_classes= DB::table('school_classes')->orderBy('numeric_no','asc')->pluck('class_name','id');
        $school_sections= DB::table('school_sections')->orderBy('priority_no','asc')->pluck('section_name','id');
        $academic_years= DB::table('academic_years')->orderBy('id','desc')->pluck('title','id');
        $exam_types = ExamType::pluck('examtype_name', 'id');
        $subjects= DB::table('subjects')->pluck('subject_name','id');

        return view('exam.exam_report', compact('school_classes', 'school_sections','academic_years', 'exam_types', 'subjects'));
    }

    public function exam_report_class_term(Request $request){
        $examQuery = Exam::where('school_class_id', $request->school_class_id)
                    ->where('school_section_id', $request->school_section_id)
                    ->where('exam_type_id', $request->exam_type_id)
                    ->where('academic_year_id', $request->academic_year_id);
        $exams = $examQuery->orderBy('roll')->get();
        if(count($exams) == 0){
            \Session::flash('flash_error', 'Exam report not found.');
            return redirect()->back();
        }

        $maxMarks = $exams->max('obtain_mark');
        $avgMarks = $exams->avg('obtain_mark');
        // dd($exams, $maxMarks, $avgMarks);
        return view('exam.exam_report_class_term', compact('exams', 'maxMarks','avgMarks'));
    }

    public function exam_report_class_subject(Request $request){
        $exams = Exam::with(['user','student','examtype'])->where('school_class_id', $request->school_class_id)
                    ->where('school_section_id', $request->school_section_id)
                    ->where('subject_id', $request->subject_id)
                    ->where('academic_year_id', $request->academic_year_id)
                    ->orderBy('roll')->get();
        if(count($exams) == 0){
            \Session::flash('flash_error', 'Exam report not found.');
            return redirect()->back();
        }

        $subject_total = Exam::with(['term','user','student'])
                        ->join('students', 'students.user_id', '=', 'exams.user_id')
                        ->join('subjects', 'subjects.id', '=', 'exams.subject_id')
                        ->join('exam_types', 'exam_types.id', '=', 'exams.exam_type_id')
                        ->where('exams.school_class_id', $request->school_class_id)
                        ->where('exams.school_section_id', $request->school_section_id)
                        ->where('exams.academic_year_id', $request->academic_year_id)
                        ->where('exams.subject_id', $request->subject_id)
                        ->select(
                            'students.first_name',
                            'students.middle_name',
                            'students.last_name',
                            'roll',
                            // 'exam_type_id',
                            'exam_types.term_id',
                            'subjects.subject_name',
                            DB::raw('SUM(added_mark) as total_marks')
                        )
                        ->groupBy(
                            'roll',
                            // 'exam_type_id',
                            'exam_types.term_id',
                            'subjects.id',
                            'students.first_name',
                            'students.middle_name',
                            'students.last_name',
                            'subjects.subject_name'
                        )
                        ->get();

        $grades = Grading::orderBy('grade_point', 'desc')->get();
        // dd($exams,$subject_total,$grades);

        return view('exam.exam_report_class_subject', compact('exams', 'subject_total','grades'));
    }

    public function exam_report_class_student(Request $request){
        $exams = Exam::with(['user','student','examtype'])->where('school_class_id', $request->school_class)
                    ->where('school_section_id', $request->school_section)
                    ->where('academic_year_id', $request->academic_year)
                    ->where('roll',$request->roll)
                    ->orderBy('roll')->get();
                    // dd(count($exams));
        if(count($exams) == 0){
            \Session::flash('flash_error', 'Exam report not found.');
            return redirect()->back();
        }

        $subject_total = Exam::with(['term','user','student'])
                        ->join('students', 'students.user_id', '=', 'exams.user_id')
                        ->join('subjects', 'subjects.id', '=', 'exams.subject_id')
                        ->join('exam_types', 'exam_types.id', '=', 'exams.exam_type_id')
                        ->where('exams.school_class_id', $request->school_class)
                        ->where('exams.school_section_id', $request->school_section)
                        ->where('exams.academic_year_id', $request->academic_year)
                        ->where('exams.roll', $request->roll)
                        ->select(
                            'students.first_name',
                            'students.middle_name',
                            'students.last_name',
                            'roll',
                            // 'exam_type_id',
                            'exam_types.term_id',
                            'subjects.subject_name',
                            DB::raw('SUM(marks) as total_marks')
                        )
                        ->groupBy(
                            'roll',
                            // 'exam_type_id',
                            'exam_types.term_id',
                            'subjects.id',
                            'students.first_name',
                            'students.middle_name',
                            'students.last_name',
                            'subjects.subject_name'
                        )
                        ->get();

        $grades = Grading::orderBy('grade_point', 'desc')->get();
        // dd($exams,$subject_total,$grades);
        return view('exam.exam_report_by_student', compact('exams', 'subject_total','grades'));
    }

    public function exam_report_class_student_2(Request $request){
        $classId = $request->school_class;
        $sectionId = $request->school_section;
        $academicYearId = $request->academic_year;
        $total_students = StudentAcademicHistory::where([
            'school_class_id'=>$classId,
            'school_section_id'=>$sectionId,
            'academic_year_id'=>$academicYearId,
        ])->count();
        $userId = StudentAcademicHistory::where([
            'school_class_id'=>$classId,
            'school_section_id'=>$sectionId,
            'academic_year_id'=>$academicYearId,
            'roll'=>$request->roll,
        ])->first()->user_id;

        // Common Info
        $stu_name = Student::where('user_id',$userId)->select('first_name','middle_name','last_name')->first();
        $school_class = SchoolClass::findorFail($classId);
        $school_section = SchoolSection::findorFail($sectionId);
        $academic_year = AcademicYear::findorFail($academicYearId);
        $exams = DB::table('exams')
                ->join('exam_types', 'exams.exam_type_id', '=', 'exam_types.id')
                ->join('exam_criterias', 'exam_types.exam_criteria_id', '=', 'exam_criterias.id')
                ->join('subjects', 'exams.subject_id', '=', 'subjects.id')
                ->join('terms', 'exam_types.term_id', '=', 'terms.id')
                ->select(
                    'exams.*',
                    'subjects.subject_name',
                    'terms.title',
                    'exam_types.term_id',
                    'exam_types.examtype_name',
                    'exam_criterias.criteria_name',
                )
                ->where('exams.user_id', $userId)
                ->where('exams.academic_year_id', $academicYearId)
                ->orderBy('exam_types.term_id')
                ->get();
        // dd($exams);

        if ($exams->isEmpty()) {
            return response()->json(['message' => 'No exam data found'], 404);
        }

        // Group by term
        $terms = $exams->groupBy('term_id');
        $resultData = [];
        $resultSummary = [];
        $resultSummary_tbl2 = [];

        foreach ($terms as $termId => $termExams) {
            $subjects = [];
            $grandTotal = 0;
            $totalGradePoints = 0;
            $subjectCount = 0;
            $criteriaNms = $termExams->pluck('criteria_name')->unique()->all();

            $criteriaNames = ExamCriteria::whereIn('criteria_name', $criteriaNms)
                ->orderBy('id')
                ->pluck('criteria_name')
                ->all();
            // dd($criteriaNames);
            $termCriteriaTotals = array_fill_keys($criteriaNames, 0);
            // Group by subject within the term
            $subjectsByTerm = $termExams->groupBy('subject_id');

            foreach ($subjectsByTerm as $subjectId => $subjectData) {
                // dd($subjectData);
                $criteriaMarks = [];
                $subjectTotal = 0;
                $subjectCriteriaMarks = array_fill_keys($criteriaNames, 0);

                foreach ($subjectData as $mark) {
                    $cname = $mark->criteria_name ?? 'Unknown';
                    $criteriaMarks[$cname] = $mark->added_mark;
                    $subjectTotal += $mark->added_mark;
                    $termCriteriaTotals[$cname] += $mark->added_mark;
                }

                $highestMark = $this->calculateHighestMark($academicYearId,$termId,$subjectId);
                $gP = $this->calculateGradeP($subjectTotal);
                // dd($gP);
                $grade =$gP['grade'];
                $gpoint =$gP['gpoint'];

                $subjects[] = [
                    'subject_id' => $subjectId,
                    'subject_name' => $subjectData->first()->subject_name,
                    'criteria_marks' => $criteriaMarks,
                    'total' => $subjectTotal,
                    'highest' => $highestMark,
                    'letter_grade' => $grade,
                    'grade_point' => $gpoint,
                ];

                $resultSummary[$subjectData->first()->subject_name][] = [
                    'term_name' => $termExams->first()->title,
                    'total' => $subjectTotal,
                    'letter_grade' => $grade,
                    'grade_point' => $gpoint,
                ];

                $grandTotal += $subjectTotal;
                $totalGradePoints += $gpoint;
                $subjectCount++;

            }
            $gpa = $subjectCount > 0 ? round($totalGradePoints / $subjectCount, 2) : 0;
            $letter_grade = $this->calculateLetterGrade($gpa);
            $resultData[] = [
                'term_id' => $termId,
                'term_name' => $termExams->first()->title,
                'academic_year_id' => $academicYearId,
                'roll' => $termExams->first()->roll,
                'criteria_headers' => $criteriaNames,
                'criteria_totals' => $termCriteriaTotals,
                'subjects' => $subjects,
                'total_mark'=> count($subjects)*100,
                'grand_total' => $grandTotal,
                'grand_points' => $totalGradePoints,
                'gpa' => $gpa,
                'letter_grade'=> $letter_grade
            ];

            $resultSummary_tbl2[$termExams->first()->title] = [
                'full_marks' => count($subjects)*100,
                'obtained_marks' => $grandTotal,
                'gpa' => $gpa,
                'letter_grade'=> $letter_grade,
            ];
        }
        // dd($resultSummary_tbl2);
        return view('exam.exam_report_by_student_2', compact('stu_name', 'school_class','school_section','academic_year','resultData','resultSummary','resultSummary_tbl2','total_students'));
    }

    private function calculateGradeP($subjectTotal){
        $grading = Grading::where('starting_marks', '<=', $subjectTotal)
                         ->where('ending_marks', '>=', $subjectTotal)
                         ->first();
        return [
            'grade'=>$grading->letter_grade,
            'gpoint'=>$grading->grade_point,
        ];
    }

    private function calculateLetterGrade($gradePoint){
        // dd($gradePoint);
        $grades = Grading::orderBy('grade_point')->get();

        if ($gradePoint >= $grades->max('grade_point')) {
            return $grades->where('grade_point', $grades->max('grade_point'))->first()->letter_grade;
        }

        if ($gradePoint <= $grades->min('grade_point')) {
            return $grades->where('grade_point', $grades->min('grade_point'))->first()->letter_grade;
        }

        // Find the upper and lower bounds
        $lower = $grades->where('grade_point', '<=', $gradePoint)->sortByDesc('grade_point')->first();
        $upper = $grades->where('grade_point', '>=', $gradePoint)->sortBy('grade_point')->first();

        // If exact match found
        if ($lower->grade_point == $gradePoint) {
            return $lower->letter_grade;
        }

        return $lower->letter_grade;
    }

    private function calculateHighestMark($academicYearId,$termId,$subjectId){
        $exams = DB::table('exams')
                ->join('exam_types', 'exams.exam_type_id', '=', 'exam_types.id')
                ->join('terms', 'exam_types.term_id', '=', 'terms.id')
                ->select(
                    'exams.*',
                    'terms.title',
                    'exam_types.term_id',
                )
                ->where('exam_types.term_id', $termId)
                ->where('exams.academic_year_id', $academicYearId)
                ->where('exams.subject_id', $subjectId)
                ->get();
        // Group by user
        $users = $exams->groupBy('user_id');
        $highestMrk = 0;
        foreach($users as $user){
            $totalAddedMark = 0;
            foreach($user as $adMrk){
                $totalAddedMark += $adMrk->added_mark;
            }
            $highestMrk = ($totalAddedMark > $highestMrk) ? $totalAddedMark : $highestMrk;
        }
        return $highestMrk;
    }

}
