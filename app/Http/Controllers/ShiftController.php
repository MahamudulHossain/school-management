<?php

namespace App\Http\Controllers;

use App\Models\ShiftPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ShiftController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        abort_if(Gate::denies('ShiftManagement'), redirect('error'));
        $data = ShiftPeriod::select('shift_id',DB::Raw("COUNT('period_number')-2 as pn"))->groupBy('shift_id')->orderBy('shift_id', 'asc')->get();
        return view('shift.index',compact('data'));
    }

    public function show($shift_id){
        abort_if(Gate::denies('ShiftManagement'), redirect('error'));
        $data = ShiftPeriod::where('shift_id',$shift_id)->get();
        $title = $shift_id == 0 ? 'Morning Shift' : 'Day Shift';
        return view('shift.show',compact('data','title'));
    }

    public function edit($shift_id){
        abort_if(Gate::denies('ShiftManagement'), redirect('error'));
        $data = ShiftPeriod::where('shift_id',$shift_id)->get();
        $title = $shift_id == 0 ? 'Morning Shift' : 'Day Shift';
        $perido_number = range(0,8);
        $types = ['assembly','tiffin','regular'];
        return view('shift.edit',compact('data','title','shift_id','perido_number','types'));
    }

    public function update(Request $request){
        abort_if(Gate::denies('ShiftManagement'), redirect('error'));
        $request->validate([
            'period_number.*' => 'required',
            'type.*' => 'required',
            'title.*' => 'required',
            'start_time.*' => 'required',
            'end_time.*' => 'required',
        ]);

        ShiftPeriod::where('shift_id',$request->shift_id)->delete();

        $count = count($request->period_number);
        for($i=0; $i<$count; $i++){
            $data = new ShiftPeriod();
            $data->shift_id = $request->shift_id;
            $data->period_number = $request->period_number[$i];
            $data->type = $request->type[$i];
            $data->title = $request->title[$i];
            $data->start_time = $request->start_time[$i];
            $data->end_time = $request->end_time[$i];
            $data->save();
        }
        \Session::flash('flash_message','Updated Successfully');
        return redirect()->back();
    }

    public function destroy($id){
        abort_if(Gate::denies('ShiftManagement'), redirect('error'));
        $data = ShiftPeriod::findOrFail($id);
        $data->delete();
        \Session::flash('flash_message','Deleted Successfully');
        return redirect()->back();
    }
}
