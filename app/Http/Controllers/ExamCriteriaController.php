<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\ExamCriteria;

class ExamCriteriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Also check whether the user email is superadmin@eidyict.com or not
        $this->middleware(function ($request, $next) {
            if (Auth::user()->email !== 'superadmin@eidyict.com') {
                abort(403);
            }
            return $next($request);
        });
    }

    public function index()
    {
        $items = ExamCriteria::orderBy('id', 'desc')->get();
        return view('exam_criteria.index', compact('items'));
    }


    public function create()
    {
        return view('exam_criteria.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'criteria_name' => 'required|string|max:255|unique:exam_criterias,criteria_name',
            'status' => 'required|in:active,inactive',
        ]);

        ExamCriteria::create($validated);
        \Session::flash('flash_success', 'Exam criteria created successfully');
        return redirect()->route('exam-criteria.index');
    }


    public function edit($id)
    {
        $examCriteria = ExamCriteria::findOrFail($id);
        return view('exam_criteria.edit', compact('examCriteria'));
    }


    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'criteria_name' => 'required|string|max:255|unique:exam_criterias,criteria_name,' . $id,
            'status' => 'required|in:active,inactive',
        ]);
        $examCriteria = ExamCriteria::findOrFail($id);
        $examCriteria->update($validated);
        \Session::flash('flash_success', 'Exam criteria updated successfully');
        return redirect()->route('exam-criteria.index');
    }

    public function destroy($id)
    {
        $examCriteria = ExamCriteria::findOrFail($id);
        $examCriteria->delete();
        \Session::flash('flash_success', 'Exam criteria deleted successfully');
        return redirect()->route('exam-criteria.index');
    }
}
