<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        abort_if(Gate::denies('EmployeeAccess'), redirect('error'));
        $base = User::with([
            'roles','employee','user_type','profile','imageprofile'
            ])
            ->where('user_type_id',4);
        if(Auth::user()->user_type_id == 4){ // Employee
            $base = $base->where('id',Auth::user()->id);
        }
            $employees = $base->orderBy('id','desc')->get();
        return view('employees.index',compact('employees'));
    }

    public function personal_profile_update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->update($request->all());

        \Session::flash('flash_success', 'Employee Profile updated successfully');
        return redirect()->back();
    }
}
