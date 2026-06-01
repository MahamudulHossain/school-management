<?php

namespace App\Http\Controllers;

use App\Models\Grading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\GradingRequest;

class GradingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        abort_if(Gate::denies('ManageGradingSystem'), redirect('error'));
        $grades = Grading::orderBy('grade_point', 'desc')->get();
        return view('grading.index', ['grades' => $grades]);
    }

    public function create()
    {
        abort_if(Gate::denies('ManageGradingSystem'), redirect('error'));
        return view('grading.create');
    }

    public function store(GradingRequest $request)
    {
        abort_if(Gate::denies('ManageGradingSystem'), redirect('error'));
        $grade = Grading::create($request->all());
        \Session::flash('flash_message','Successfully Created');
        return redirect('grading');
    }

    public function show($id)
    {
        abort_if(Gate::denies('ManageGradingSystem'), redirect('error'));
        $grade = Grading::findOrFail($id);
        return view('grading.show', ['grading' => $grade]);
    }

    public function edit($id)
    {
        abort_if(Gate::denies('ManageGradingSystem'), redirect('error'));
        $grading = Grading::findOrFail($id);
        return view('grading.edit', ['grading' => $grading]);
    }

    public function update(GradingRequest $request, Grading $grading)
    {
        abort_if(Gate::denies('ManageGradingSystem'), redirect('error'));
        $grading->update($request->all());
        \Session::flash('flash_message','Successfully Updated');
        return redirect('grading');
    }

    public function destroy($id)
    {
        abort_if(Gate::denies('ManageGradingSystem'), redirect('error'));
        $grade = Grading::findOrFail($id);
        $grade ->delete();
        return redirect('grading');
    }
}
