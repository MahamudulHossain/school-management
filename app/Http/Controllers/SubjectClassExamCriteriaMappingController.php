<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\ExamCriteria;
use Illuminate\Http\Request;
use App\Models\SchoolClassSubject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\SubjectClassExamCriteriaMapping;

class SubjectClassExamCriteriaMappingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        abort_if(Gate::denies('SubjectClassExamCriteriaMapping'), redirect('error'));
        $data = [];
        $schoolClasses = SubjectClassExamCriteriaMapping::select('school_class_id')->with('school_class')->groupBy('school_class_id')->get();
        foreach ($schoolClasses as $schoolClass) {
            $mappings = [];
            $subjects = SubjectClassExamCriteriaMapping::where('school_class_id', $schoolClass->school_class_id)
                ->with(['subject'])
                ->select('subject_id')
                ->groupBy('subject_id')
                ->get();

            foreach ($subjects as $subject) {
                $examCriteria = SubjectClassExamCriteriaMapping::where(['school_class_id'=>$schoolClass->school_class_id, 'subject_id'=>$subject->subject_id])
                    ->with(['exam_criteria'])
                    ->get();
                $exam_criteria_names = $examCriteria->pluck('exam_criteria.criteria_name')->toArray();
                $mappings[] = (object)[
                    'school_class' => $schoolClass->school_class,
                    'subject' => $subject->subject,
                    'exam_criteria_names' => $exam_criteria_names,
                ];

            }
            array_push($data, $mappings);
        }

        // Creating a flat array for easier iteration in the view
        $flatArr = [];
        foreach ($data as $mappings) {
            foreach ($mappings as $mapping) {
                $flatArr[] = $mapping;
            }
        }

        return view('subject_class_examCriteria_mappings.index', compact('flatArr'));
    }

    public function create()
    {
        abort_if(Gate::denies('SubjectClassExamCriteriaMapping'), redirect('error'));
        $classes = SchoolClass::orderBy('numeric_no', 'asc')->get();
        $examCriterias = ExamCriteria::where('status','active')->get();
        return view('subject_class_examCriteria_mappings.create', compact('classes', 'examCriterias'));
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('SubjectClassExamCriteriaMapping'), redirect('error'));

        $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_criteria_id' => 'required|array',
            'exam_criteria_id.*' => 'exists:exam_criterias,id',
        ]);

        $school_class_id = $request->input('school_class_id');
        $subject_id = $request->input('subject_id');
        $exam_criteria_ids = $request->input('exam_criteria_id');

        foreach ($exam_criteria_ids as $exam_criteria_id) {
            SubjectClassExamCriteriaMapping::firstOrCreate([
                'school_class_id' => $school_class_id,
                'subject_id' => $subject_id,
                'exam_criteria_id' => $exam_criteria_id,
            ]);
        }

        \Session::flash('flash_success', 'Subject Class Exam Criteria Mapping saved successfully');
        return redirect()->route('subject-class-exam-criteria.create');
    }

    public function edit($school_class_id, $subject_id)
    {
        abort_if(Gate::denies('SubjectClassExamCriteriaMapping'), redirect('error'));
        $mapping = SubjectClassExamCriteriaMapping::where('school_class_id', $school_class_id)
            ->where('subject_id', $subject_id)
            ->pluck('exam_criteria_id')->toArray();
        $classes = SchoolClass::orderBy('numeric_no', 'asc')->get();
        $subjects = SchoolClassSubject::where('school_class_id', $school_class_id)
            ->with('subject')
            ->get();
        $examCriterias = ExamCriteria::where('status','active')->get();
        // dd($mapping, $classes, $subjects, $examCriterias);
        return view('subject_class_examCriteria_mappings.edit', compact('mapping', 'classes', 'subjects', 'examCriterias','school_class_id','subject_id'));
    }

    public function update(Request $request, $school_class_id, $subject_id)
    {
        abort_if(Gate::denies('SubjectClassExamCriteriaMapping'), redirect('error'));

        $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_criteria_id' => 'required|array',
            'exam_criteria_id.*' => 'exists:exam_criterias,id',
        ]);

        $exam_criteria_ids = $request->input('exam_criteria_id');

        // use sync to update the exam criteria mappings
        $existingMappings = SubjectClassExamCriteriaMapping::where('school_class_id', $school_class_id)
            ->where('subject_id', $subject_id)
            ->pluck('exam_criteria_id')
            ->toArray();

        // Find the exam criteria IDs to detach
        $detachIds = array_diff($existingMappings, $exam_criteria_ids);
        // Find the exam criteria IDs to attach
        $attachIds = array_diff($exam_criteria_ids, $existingMappings);

        // Detach the old mappings
        SubjectClassExamCriteriaMapping::where('school_class_id', $school_class_id)
            ->where('subject_id', $subject_id)
            ->whereIn('exam_criteria_id', $detachIds)
            ->delete();

        // Attach the new mappings
        foreach ($attachIds as $exam_criteria_id) {
            SubjectClassExamCriteriaMapping::create([
                'school_class_id' => $school_class_id,
                'subject_id' => $subject_id,
                'exam_criteria_id' => $exam_criteria_id,
            ]);
        }

        \Session::flash('flash_success', 'Subject Class Exam Criteria Mapping updated successfully');
        return redirect()->route('subject-class-exam-criteria.index');
    }

    public function delete($school_class_id, $subject_id)
    {
        abort_if(Gate::denies('SubjectClassExamCriteriaMapping'), redirect('error'));

        SubjectClassExamCriteriaMapping::where('school_class_id', $school_class_id)
            ->where('subject_id', $subject_id)
            ->delete();

        \Session::flash('flash_success', 'Subject Class Exam Criteria Mapping deleted successfully');
        return redirect()->route('subject-class-exam-criteria.index');
    }

    public function get_exam_criteria_by_class_subject(Request $request)
    {
        $examCriterias = SubjectClassExamCriteriaMapping::where('school_class_id', $request->input('class_id'))
            ->where('subject_id', $request->input('subject_id'))
            ->with('exam_criteria')
            ->get();
            // dd($examCriterias);
        return response()->json($examCriterias);
    }
}
