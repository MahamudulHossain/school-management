<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AccountingTransport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AccountingTransportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        abort_if(Gate::denies('TransportFees'), redirect('error'));
        $academicYearId = sessionAcademicYearWithAll();
        $accounting_transport_base = AccountingTransport::query()
                                    ->whereHas('user.student_academic_histories', function ($query) use ($academicYearId) {
                                        if(is_array($academicYearId))
                                            $query->whereIn('academic_year_id', $academicYearId);
                                        else
                                            $query->where('academic_year_id', $academicYearId);
                                    })
                                    ->orderBy('is_status');
        if(Auth::user()->user_type_id == 5){ // Guardian
            $childrens = getChildInfo();
            foreach($childrens as $child){
                $userIds[] = $child->user_id;
            }
            $accounting_transport_base = $accounting_transport_base->whereIn('user_id',$userIds);
        }elseif(Auth::user()->user_type_id == 2){ // Student
            $accounting_transport_base = $accounting_transport_base->where('user_id',Auth::user()->id);
        }
        $accounting_transport = $accounting_transport_base->orderBy('id','desc')->get();
        $transport_unpaid = $accounting_transport->filter(function($act){
            return $act->is_status == 0;
        });
        $transport_paid = $accounting_transport->filter(function($actP){
            return $actP->is_status == 1;
        });
        // $total_fare_amount = $accounting_transport->sum('collect_amount');
        // $total_collection = $accounting_transport->sum(function($act) {
        //     return $act->collect_amount + $act->fine_amount - $act->discount_amount;
        // });

        return view('accounting_transport.index', compact('accounting_transport','transport_unpaid','transport_paid'));
    }

    public function assign_transportfee()
    {
        abort_if(Gate::denies('AssignTransportFees'), redirect('error'));
        $academic_years = AcademicYear::pluck('title','id');
        return view('accounting_transport.assign_transportfee', compact('academic_years'));
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('AssignTransportFees'), redirect('error'));
        $registred_transport=DB::table('transport_registrations')
            ->select('transport_registrations.user_id','transports.title','transports.id as trnID','transports.fare','students.first_name','students.middle_name','students.last_name','users.personnel_id')
            ->join('students','transport_registrations.user_id','=','students.user_id')
            ->join('transports','transport_registrations.transport_id','=','transports.id')
            ->join('users','students.user_id','=','users.id')
            ->whereNotIn('transport_registrations.user_id',(DB::table('accounting_transports')
                ->select('accounting_transports.user_id')
                ->where('accounting_transports.month',$request->month)
                ->where('accounting_transports.academic_year_id',$request->academic_year_id)
            ))
            ->get();
        $due_date = date('Y-m-d', strtotime($request->due_date));
        $academic_year_id=$request->academic_year_id;
        $month=$request->month;
        return view('accounting_transport.create',compact('registred_transport','due_date','academic_year_id', 'month'));
    }

    public function store(Request $request){
        abort_if(Gate::denies('AssignTransportFees'), redirect('error'));
        foreach ($request['user_id'] as $sid) {
            $stuid[] = $sid;
        }
        foreach ($request['transport_id'] as $tportid) {
            $transportid[] = $tportid;
        }
        foreach ($request['fare_amount'] as $fareamount) {
            $fareamounts[] = $fareamount;
        }

        $id = $stuid;
        $tid = $transportid;
        $fareamount = $fareamounts;

        $count_ids = count($id);

        if (count($fareamount) != $count_ids) throw new Exception("Bad Request Input Array lengths");
        for ($i = 0; $i < $count_ids; $i++) {
            if (empty($id[$i])) continue; // skip all the blank ones
            $accounting_transport = new AccountingTransport();
            $accounting_transport->user_id = $id[$i];
            $accounting_transport->transport_id = $tid[$i];
            $accounting_transport->fare_amount = $fareamount[$i];
            $accounting_transport->academic_year_id = $request->academic_year_id;
            $accounting_transport->month = $request->month;
            $accounting_transport->due_date = date('Y-m-d', strtotime($request->due_date));
            $accounting_transport->save();
        }
        \Session::flash('flash_success','Fare assigned successfully');
        return redirect('accounting-transport');
    }

    public function edit($id){
        abort_if(Gate::denies('AssignTransportFees'), redirect('error'));
        $data = AccountingTransport::findOrFail($id);
        // dd($data);
        return view('accounting_transport.edit', compact('data'));
    }

    public function update(Request $request,$id){
        abort_if(Gate::denies('AssignTransportFees'), redirect('error'));
        $data = AccountingTransport::findOrFail($id);
        if($data){
            $data->collect_amount = $request->collect_amount;
            $data->fine_amount = $request->fine_amount;
            $data->discount_amount = $request->discount_amount;
            $data->collect_date = date('Y-m-d', strtotime($request->collect_date));
            $data->is_status = $request->is_status;
            $data->update();
            \Session::flash('flash_success','Updated successfully added');
            return redirect('accounting-transport');
        }
    }

    public function destroy($id){
    abort_if(Gate::denies('AssignTransportFees'), redirect('error'));
       $data = AccountingTransport::findOrFail($id);
       $data->delete();
       if($data){
        \Session::flash('flash_success','Deleted added');
       }else{
        \Session::flash('flash_error','Something went wrong. Try later.');
       }
        return redirect()->back();
    }
}
