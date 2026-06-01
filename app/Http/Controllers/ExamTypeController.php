<?php

namespace App\Http\Controllers;

use App\Models\Term;
use App\Models\Subject;
use App\Models\ExamType;
use App\Models\SchoolClass;
use App\Models\ExamCriteria;
use Illuminate\Http\Request;
use App\Models\SchoolClassSubject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\Console\Input\Input;
use App\Models\SubjectClassExamCriteriaMapping;

class ExamTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        abort_if(Gate::denies('ManageExamType'), redirect('error'));
        $examtypes = ExamType::all();
        return view('examtypes.index', compact('examtypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('ManageExamType'), redirect('error'));
        $terms = DB::table('terms')->orderBy('id','desc')->pluck('title', 'id');
        $schoolClasses = DB::table('school_classes')->orderBy('numeric_no','asc')->pluck('class_name', 'id');

        return view('examtypes.create', compact('schoolClasses', 'terms'));
    }


    public function store(Request $request)
    {
        $examtypeExists = ExamType::where('school_class_id', $request->school_class_id)
            ->where('term_id', $request->term_id)
            ->where('subject_id', $request->subject_id)
            ->exists();
        if ($examtypeExists) {
            \Session::flash('flash_error', 'Exam Type Already Exists for this Class, Term and Subject');
            return Redirect::back()->withInput();
        }
        if ($request->total != 100) {
            \Session::flash('flash_error', 'Total Marks Must be 100');
            return Redirect::back()->withInput();
        }

        $term = Term::find($request->term_id);
        $class = SchoolClass::find($request->school_class_id);
        $subject = Subject::find($request->subject_id);
        $examCriteria = ExamCriteria::pluck('criteria_name','id')->toArray();
        // dd($examCriteria);

        $examtypeNames = $request->examtype_name ?? [];
        $fullMarks = $request->full_marks ?? [];
        $passMarks = $request->pass_marks ?? [];

        $count = count($examtypeNames);
        if ($count !== count($fullMarks) || $count !== count($passMarks)) {
            throw new Exception("Mismatched input array lengths");
        }

        $data = [];
        foreach ($examtypeNames as $i => $name) {
            if (empty($name)) continue;

            $data[] = [
                'examtype_name' => "{$term->title}/{$class->class_name}/{$subject->subject_name}/{$examCriteria[$name]}",
                'full_marks' => $fullMarks[$i],
                'pass_marks' => $passMarks[$i],
                'school_class_id' => $request->school_class_id,
                'term_id' => $request->term_id,
                'subject_id' => $request->subject_id,
                'exam_criteria_id' => $name,
                'exam_code' => "{$request->term_id}{$request->school_class_id}{$request->subject_id}",
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($data)) {
            ExamType::insert($data); // single query
        }


        \Session::flash('flash_message', 'Successfully Added');
        return redirect('exam-type');
    }


    public function edit(ExamType $examType)
    {
        // dd($examType);
        abort_if(Gate::denies('ManageExamType'), redirect('error'));
        $subjects = SchoolClassSubject::where('school_class_id', $examType->school_class_id)
            ->with('subject')
            ->get()
            ->pluck('subject');
        $terms = DB::table('terms')->pluck('title', 'id');
        $etype = ExamType::where('exam_code', $examType->exam_code)->get();
        $schoolClasses = DB::table('school_classes')->orderBy('numeric_no','asc')->pluck('class_name', 'id');

        return view('examtypes.edit', compact('examType', 'schoolClasses', 'terms', 'subjects', 'etype'));
    }


    public function update(Request $request, ExamType $examType)
    {
        abort_if(Gate::denies('ManageExamType'), redirect('error'));
        $curent_exam_code = $request->term_id . $request->school_class_id . $request->subject_id;
        if ($examType->exam_code != $curent_exam_code) {
            $examtypeExists = ExamType::where('school_class_id', $request->school_class_id)
                ->where('term_id', $request->term_id)
                ->where('subject_id', $request->subject_id)
                ->exists();
            if ($examtypeExists) {
                \Session::flash('flash_error', 'Exam Type Already Exist in this Class, term and Subject');
                return Redirect::back()->withInput();
            }
        } else {
            if ($request->total != 100) {
                \Session::flash('flash_error', 'Total Marks Must be 100');
                return Redirect::back()->withInput();
            }

            $del_examtype = ExamType::where('exam_code',$examType->exam_code)->delete();

            $term = Term::find($request->term_id);
            $class = SchoolClass::find($request->school_class_id);
            $subject = Subject::find($request->subject_id);
            $examCriteria = ExamCriteria::pluck('criteria_name','id')->toArray();
            // dd($examCriteria);

            $examtypeNames = $request->examtype_name ?? [];
            $fullMarks = $request->full_marks ?? [];
            $passMarks = $request->pass_marks ?? [];

            $count = count($examtypeNames);
            if ($count !== count($fullMarks) || $count !== count($passMarks)) {
                throw new Exception("Mismatched input array lengths");
            }

            $data = [];
            foreach ($examtypeNames as $i => $name) {
                if (empty($name)) continue;

                $data[] = [
                    'examtype_name' => "{$term->title}/{$class->class_name}/{$subject->subject_name}/{$examCriteria[$name]}",
                    'full_marks' => $fullMarks[$i],
                    'pass_marks' => $passMarks[$i],
                    'school_class_id' => $request->school_class_id,
                    'term_id' => $request->term_id,
                    'subject_id' => $request->subject_id,
                    'exam_criteria_id' => $name,
                    'exam_code' => "{$request->term_id}{$request->school_class_id}{$request->subject_id}",
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (!empty($data)) {
                ExamType::insert($data); // single query
            }
        }

        \Session::flash('flash_message', 'Successfully Updated');
        return redirect('exam-type');
    }


    public function destroy(ExamType $examType)
    {
        abort_if(Gate::denies('ManageExamType'), redirect('error'));
        $examType->delete();
        \Session::flash('flash_message', 'Successfully Deleted');
        return redirect('exam-type');
    }
}
