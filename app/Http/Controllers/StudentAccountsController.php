<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;
use App\Models\AccountingSfee;
use Illuminate\Support\Facades\Gate;

class StudentAccountsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        abort_if(Gate::denies('AccountingSfees'), redirect('error'));
        $accounting_sfees = AccountingSfee::with('student_class')->orderby('school_class_id')->get();
        return view('accounting_sfee.index', compact('accounting_sfees'));
    }

    public function create(){
        abort_if(Gate::denies('AccountingSfees'), redirect('error'));
        $school_classes = SchoolClass::pluck('class_name', 'id');
        return view('accounting_sfee.create',compact('school_classes'));
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('AccountingSfees'), redirect('error'));
        $this->validate($request, [
            'fee_name' => 'required',
            'amount' => 'required|numeric',
        ]);
        $feeExists=AccountingSfee::where(['school_class_id'=>$request->school_class_id,'fee_name'=>$request->fee_name])->count();
        if($feeExists){
            \Session::flash('flash_error', 'The fee name ' .$request->fee_name. ' already exists for this class');
            return redirect('sFee/create');
        }
        AccountingSfee::create($request->all());
        \Session::flash('flash_message','Successfully Added');
        return redirect('sFee');
    }

    public function edit($id)
    {
        abort_if(Gate::denies('AccountingSfees'), redirect('error'));
        $accounting_sfee = AccountingSfee::findOrFail($id);
        $school_classes = SchoolClass::pluck('class_name', 'id');
        return view('accounting_sfee.edit', compact('accounting_sfee','school_classes'));
    }

    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('AccountingSfees'), redirect('error'));
        $this->validate($request, [
            'fee_name' => 'required',
            'amount' => 'required|numeric',
        ]);
        $accounting_sfee = AccountingSfee::findOrFail($id);
        $feeExists=AccountingSfee::where(['school_class_id'=>$request->school_class_id,'fee_name'=>$request->fee_name])->where('id','!=',$id)->count();
        if($feeExists){
            \Session::flash('flash_error', 'The fee name ' .$request->fee_name. ' already exists for this class');
            return redirect('sFee/'.$id.'/edit');
        }
        $accounting_sfee->update($request->all());
        \Session::flash('flash_message','Successfully Updated');
        return redirect('sFee');
    }

    public function destroy(AccountingSfee $accounting_sfee, $id)
    {
        abort_if(Gate::denies('AccountingSfees'), redirect('error'));
        if (isset($accounting_sfee->accounting_sinvoices) && count($accounting_sfee->accounting_sinvoices) > 0) {
            \Session::flash('flash_error','Can not Delete this as '. count($accounting_sfee->accounting_sinvoices).' entry associated with this fee.');
            return redirect('sFee');
        }
        AccountingSfee::destroy($id);
        \Session::flash('flash_message','Successfully Deleted');
        return redirect('sFee');
    }
}
