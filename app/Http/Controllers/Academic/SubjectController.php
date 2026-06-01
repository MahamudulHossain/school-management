<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        abort_if(Gate::denies('SubjectAccess'), redirect('error'));
        $subjects = Subject::all();
        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        abort_if(Gate::denies('SubjectCreate'), redirect('error'));
        return view('subjects.create');
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('SubjectCreate'), redirect('error'));
        $this->validate($request, [
            'subject_name' => 'required|unique:subjects,subject_name'
        ]);
        $subject = Subject::create($request->all());
        \Session::flash('flash_message', 'Successfully Added');

        return redirect()->route('subject.index');
    }

    public function show(Subject $subject)
    {
        abort_if(Gate::denies('SubjectAccess'), redirect('error'));
        return view('subjects.show', compact('subject'));
    }

    public function edit(Subject $subject)
    {
        abort_if(Gate::denies('SubjectAccess'), redirect('error'));
        // Check if the subject exists
        if (!$subject) {
            return redirect()->route('subject.index')->with('error', 'Subject not found');
        }
        return view('subjects.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        abort_if(Gate::denies('SubjectAccess'), redirect('error'));
        $this->validate($request, [
            'subject_name' => 'required|unique:subjects,subject_name,' . $subject->id,
        ]);
        $subject->update($request->all());
        \Session::flash('flash_message', 'Successfully Updated');

        return redirect()->route('subject.index');
    }

    public function destroy(Subject $subject)
    {
        abort_if(Gate::denies('SubjectAccess'), redirect('error'));
        $subject->delete();
        \Session::flash('flash_message', 'Successfully Deleted');
        return redirect()->route('subject.index');
    }
}
