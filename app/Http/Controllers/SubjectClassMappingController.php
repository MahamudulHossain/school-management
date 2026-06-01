<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use App\Models\SchoolClassSubject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SubjectClassMappingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        abort_if(Gate::denies('SubjectClassMapping'), redirect('error'));
        $schoolClasses = SchoolClassSubject::select('school_class_id')
            ->groupBy('school_class_id')
            ->with(['school_class'])
            ->get();
        $mappings = [];
        foreach ($schoolClasses as $schoolClass) {
            $subjects = SchoolClassSubject::where('school_class_id', $schoolClass->school_class_id)
                ->with('subject')
                ->get();
            $subject_ids = $subjects->pluck('subject.subject_name')->toArray();
            $mappings[] = (object)[
                'school_class' => $schoolClass->school_class,
                'subject_ids' => $subject_ids,
            ];
        }
        // dd($mappings);
        return view('subject_class_mappings.index', compact('mappings'));
    }

    public function create()
    {
        abort_if(Gate::denies('SubjectClassMapping'), redirect('error'));
        $classes = SchoolClass::orderBy('numeric_no', 'asc')->get();
        $subjects = Subject::all();
        return view('subject_class_mappings.create', compact('classes', 'subjects'));
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('SubjectClassMapping'), redirect('error'));

        $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|array',
            'subject_id.*' => 'exists:subjects,id',
        ]);

        $school_class_id = $request->input('school_class_id');
        $subject_ids = $request->input('subject_id');

        foreach ($subject_ids as $subject_id) {
            SchoolClassSubject::firstOrCreate([
                'school_class_id' => $school_class_id,
                'subject_id' => $subject_id,
            ]);
        }
        \Session::flash('flash_success', 'Subject Class Mapping created successfully');
        return redirect()->route('subject-class-mapping.index');
    }

    public function edit($school_class_id)
    {
        abort_if(Gate::denies('SubjectClassMapping'), redirect('error'));
        $classes = SchoolClass::orderBy('numeric_no', 'asc')->get();
        $subjects = Subject::all();

        $mappedSubjects = SchoolClassSubject::where('school_class_id', $school_class_id)
            ->pluck('subject_id')
            ->toArray();

        return view('subject_class_mappings.edit', compact('classes', 'subjects', 'school_class_id', 'mappedSubjects'));
    }

    public function update(Request $request, $school_class_id)
    {
        abort_if(Gate::denies('SubjectClassMapping'), redirect('error'));

        $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|array',
            'subject_id.*' => 'exists:subjects,id',
        ]);

        $subject_ids = $request->input('subject_id');
        $schoolClass = SchoolClass::findOrFail($school_class_id);
        $schoolClass->subjects()->sync($subject_ids);

        \Session::flash('flash_success', 'Subject Class Mapping updated successfully');
        return redirect()->route('subject-class-mapping.index');
    }

    public function get_subjects_by_class($class_id)
    {
        $subjects = SchoolClassSubject::where('school_class_id', $class_id)
            ->with('subject')
            ->get()
            ->pluck('subject');

        return response()->json($subjects);
    }
}
