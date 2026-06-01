<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SchoolClassController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
       abort_if(Gate::denies('ClassAccess'), redirect('error'));
        $schoolClasses = SchoolClass::orderBy('numeric_no','asc')->get();
        return view('schoolClasses.index', compact('schoolClasses'));
    }

    public function create()
    {
        abort_if(Gate::denies('ClassCreate'), redirect('error'));
        return view('schoolClasses.create');
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('ClassCreate'), redirect('error'));
        $this->validate($request, [
            'class_name' => 'required|unique:school_classes,class_name',
            'number_of_periods' => 'required|integer',
            'numeric_no' => 'required|unique:school_classes,numeric_no|integer',
        ]);
        $schoolClass = SchoolClass::create($request->all());
        \Session::flash('flash_message', 'Successfully Added');

        return redirect()->route('schoolClass.index');
    }

    public function edit(SchoolClass $schoolClass)
    {
        abort_if(Gate::denies('ClassAccess'), redirect('error'));
        // Check if the class exists
        if (!$schoolClass) {
            return redirect()->route('schoolClass.index')->with('error', 'Class not found');
        }
        return view('schoolClasses.edit', compact('schoolClass'));
    }

    public function update(Request $request, SchoolClass $schoolClass)
    {
        abort_if(Gate::denies('ClassAccess'), redirect('error'));
        $this->validate($request, [
            'class_name' => 'required|unique:school_classes,class_name,' . $schoolClass->id,
            'number_of_periods' => 'required|integer',
            'numeric_no' => 'required|unique:school_classes,numeric_no,' . $schoolClass->id . '|integer',
        ]);
        $schoolClass->update($request->all());
        \Session::flash('flash_message', 'Successfully Updated');

        return redirect()->route('schoolClass.index');
    }

    public function show(SchoolClass $schoolClass)
    {
       abort_if(Gate::denies('ClassAccess'), redirect('error'));
        return view('schoolClasses.show', compact('schoolClass'));
    }

    public function destroy(SchoolClass $schoolClass)
    {
        abort_if(Gate::denies('ClassAccess'), redirect('error'));
        $schoolClass->delete();
        \Session::flash('flash_message', 'Successfully Deleted');
        return redirect()->route('schoolClass.index');
    }

}
