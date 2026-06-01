<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        abort_if(Gate::denies('TeacherAccess'), redirect('error'));
        $teachers = User::with(['roles','user_type','teacher','profile','imageprofile'])->where('user_type_id',3)->orderBy('id','desc')->get();
        return view('teachers.index',compact('teachers'));
    }

    public function personal_profile_update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->update($request->all());

        \Session::flash('flash_success', 'Teacher Profile updated successfully');
        return redirect()->back();
    }
}
