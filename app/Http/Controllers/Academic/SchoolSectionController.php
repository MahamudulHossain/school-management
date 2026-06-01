<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\SchoolSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SchoolSectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
       abort_if(Gate::denies('SectionAccess'), redirect('error'));
        $schoolSections = SchoolSection::all();
        return view('schoolSections.index', compact('schoolSections'));
    }

    public function create()
    {
        abort_if(Gate::denies('SectionCreate'), redirect('error'));
        return view('schoolSections.create');
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('SectionCreate'), redirect('error'));
        $this->validate($request, [
            'section_name' => 'required|unique:school_sections,section_name',
            'priority_no' => 'required|integer|unique:school_sections,priority_no',
        ]);
        $schoolSection = SchoolSection::create($request->all());
        \Session::flash('flash_message', 'Successfully Added');

        return redirect()->route('schoolSection.index');
    }

    public function edit(SchoolSection $schoolSection)
    {
        abort_if(Gate::denies('SectionAccess'), redirect('error'));
        // Check if the section exists
        if (!$schoolSection) {
            return redirect()->route('schoolSection.index')->with('error', 'Section not found');
        }
        return view('schoolSections.edit', compact('schoolSection'));
    }

    public function update(Request $request, SchoolSection $schoolSection)
    {
        abort_if(Gate::denies('SectionAccess'), redirect('error'));
        $this->validate($request, [
            'section_name' => 'required|unique:school_sections,section_name,' . $schoolSection->id,
            'priority_no' => 'required|integer|unique:school_sections,priority_no,' . $schoolSection->id,
        ]);
        $schoolSection->update($request->all());
        \Session::flash('flash_message', 'Successfully Updated');

        return redirect()->route('schoolSection.index');
    }

    public function show(SchoolSection $schoolSection)
    {
       abort_if(Gate::denies('SectionAccess'), redirect('error'));
        return view('schoolSections.show', compact('schoolSection'));
    }

    public function destroy(SchoolSection $schoolSection)
    {
        abort_if(Gate::denies('SectionAccess'), redirect('error'));
        $schoolSection->delete();
        \Session::flash('flash_message', 'Successfully Deleted');
        return redirect()->route('schoolSection.index');
    }

}
