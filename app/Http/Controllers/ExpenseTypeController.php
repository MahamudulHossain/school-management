<?php

namespace App\Http\Controllers;

use App\Models\ExpenseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ExpenseTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        abort_if(Gate::denies('ManageExpenseType'), redirect('error'));
        $expense_types = ExpenseType::orderBy('id','desc')->get();
        return view('expense_type.index', compact('expense_types'));
    }


    public function create()
    {
        abort_if(Gate::denies('ManageExpenseType'), redirect('error'));
        return view('expense_type.create');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'expense_name' => 'required',
        ]);
        ExpenseType::create($request->all());
        \Session::flash('flash_success','Successfully Added');
        return redirect('expense-type');
    }

    public function edit(ExpenseType $expense_type)
    {
        abort_if(Gate::denies('ManageExpenseType'), redirect('error'));
        return view('expense_type.edit',compact('expense_type'));
    }

    public function update(Request $request, ExpenseType $expense_type)
    {
        $this->validate($request, [
            'expense_name' => 'required|unique:expense_types,expense_name,'.$expense_type->id,
        ]);
        $expense_type->update($request->all());
        \Session::flash('flash_success','Successfully Updated');
        return redirect('expense-type');
    }
    public function destroy(ExpenseType $expense_type)
    {
        abort_if(Gate::denies('ManageExpenseType'), redirect('error'));
        $expense_type->delete();
        \Session::flash('flash_success','Successfully Deleted');
        return redirect('expense-type');
    }
}
