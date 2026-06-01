<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class LeaveTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        abort_if(Gate::denies('ManageLeaveType'), redirect('error'));
        $leave_types = LeaveType::orderBy('id', 'desc')->get();
        return view('leave_types.index', compact('leave_types'));
    }

    public function create()
    {
        abort_if(Gate::denies('ManageLeaveType'), redirect('error'));
        return view('leave_types.create');
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('ManageLeaveType'), redirect('error'));
        $this->validate($request, [
            'leave_type_name' => 'required|min:2|max:32|unique:leave_types,leave_type_name'
        ]);

        $leave_type = LeaveType::create($request->all());
        \Session::flash('flash_message', 'Successfully Added');

        return redirect()->route('leave-type.index');
    }

    public function show(LeaveType $leave_type)
    {
        abort_if(Gate::denies('ManageLeaveType'), redirect('error'));
        return view('leave_types.show', compact('leave_type'));
    }

    public function edit(LeaveType $leave_type)
    {
        abort_if(Gate::denies('ManageLeaveType'), redirect('error'));
        // Check if the leave type exists
        if (!$leave_type) {
            return redirect()->route('leave-type.index')->with('error', 'Leave Type not found');
        }
        return view('leave_types.edit', compact('leave_type'));
    }

    public function update(Request $request, LeaveType $leave_type)
    {
        abort_if(Gate::denies('ManageLeaveType'), redirect('error'));
        $this->validate($request, [
            'leave_type_name' => 'required|min:2|max:32|unique:leave_types,leave_type_name,' . $leave_type->id,
        ]);
        $leave_type->update($request->all());
        \Session::flash('flash_message', 'Successfully Updated');

        return redirect()->route('leave-type.index');
    }

    public function destroy(LeaveType $leave_type)
    {
        abort_if(Gate::denies('ManageLeaveType'), redirect('error'));
        $leave_type->delete();
        \Session::flash('flash_message', 'Successfully Deleted');
        return redirect()->route('leave-type.index');
    }
}
