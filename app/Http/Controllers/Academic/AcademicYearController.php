<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AcademicYearController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
       abort_if(Gate::denies('AcademicYearAccess'), redirect('error'));
        $academicYears = AcademicYear::orderBy('id','desc')->get();
        return view('academicYears.index', compact('academicYears'));
    }

    public function create()
    {
        abort_if(Gate::denies('AcademicYearCreate'), redirect('error'));
        return view('academicYears.create');
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('AcademicYearCreate'), redirect('error'));
        $validated = $this->validate($request, [
            'title' => 'required|unique:academic_years,title',
            'description' => 'nullable',
            'start_date' => 'required|date|unique:academic_years,start_date',
            'end_date' => 'required|date|unique:academic_years,end_date',
        ]);
        $data = $validated;
        $data['start_date'] = date('Y-m-d', strtotime($validated['start_date']));
        $data['end_date'] = date('Y-m-d', strtotime($validated['end_date']));
        $academicYear = AcademicYear::create($data);
        \Session::flash('flash_message', 'Successfully Added');

        return redirect()->route('academicYear.index');
    }

    public function edit(AcademicYear $academicYear)
    {
        abort_if(Gate::denies('AcademicYearAccess'), redirect('error'));
        // Check if the academic year exists
        if (!$academicYear) {
            return redirect()->route('academicYear.index')->with('error', 'Academic Year not found');
        }
        return view('academicYears.edit', compact('academicYear'));
    }

    public function update(Request $request, AcademicYear $academicYear)
    {
        abort_if(Gate::denies('AcademicYearAccess'), redirect('error'));
        $validated = $this->validate($request, [
            'title' => 'required|unique:academic_years,title,' . $academicYear->id,
            'description' => 'nullable',
            'start_date' => 'required|date|unique:academic_years,start_date,' . $academicYear->id,
            'end_date' => 'required|date|unique:academic_years,end_date,' . $academicYear->id,

        ]);
        $validated['start_date'] = date('Y-m-d', strtotime($validated['start_date']));
        $validated['end_date'] = date('Y-m-d', strtotime($validated['end_date']));
        $academicYear->update($validated);
        \Session::flash('flash_message', 'Successfully Updated');

        return redirect()->route('academicYear.index');
    }

    public function show(AcademicYear $academicYear)
    {
       abort_if(Gate::denies('AcademicYearAccess'), redirect('error'));
        return view('academicYears.show', compact('academicYear'));
    }

    public function destroy(AcademicYear $academicYear)
    {
        abort_if(Gate::denies('AcademicYearAccess'), redirect('error'));
        $academicYear->delete();
        \Session::flash('flash_message', 'Successfully Deleted');
        return redirect()->route('academicYear.index');
    }

}
