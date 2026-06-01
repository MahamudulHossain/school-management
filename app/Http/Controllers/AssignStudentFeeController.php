<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Guardian;
use App\Models\SchoolClass;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\SchoolSection;
use App\Models\AccountingSfee;
use App\Models\StudentGuardian;
use App\Models\AccountingSinvoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AssignStudentFeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function assign_fees()
    {
        abort_if(Gate::denies('AssignSfees'), redirect('error'));
        $student_fees = AccountingSfee::pluck('fee_name', 'id');
        $school_classes = DB::table('school_classes')->pluck('class_name','id');
        $academic_years = DB::table('academic_years')->pluck('title','id');
        $school_sections = DB::table('school_sections')->orderBy('priority_no','asc')->pluck('section_name','id');
        $sessionAcademicYear = getSessionAcademicYear();
        return view('assign_sFees.select_students', compact('student_fees', 'school_classes', 'academic_years', 'school_sections','sessionAcademicYear'));
    }

    public function selectajax_feeType(Request $request)
    {
        abort_if(Gate::denies('AssignSfees'), redirect('error'));
        $feeTypes = DB::table('accounting_sfees')->where('school_class_id', $request->school_class_id)->pluck('fee_name','id');
        $data = '<option value="" disabled selected>Select Fee Type</option>';
        foreach($feeTypes as $id => $name){
            $data .= '<option value='.$id.'>'.$name.'</option>';
        }
        return response()->json($data);
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('AssignSfees'), redirect('error'));
        $request->validate([
            'academic_year_id' => 'required',
            'school_class_id' => 'required',
            'school_section_id' => 'required',
            'fee_type_id' => 'required',
            'due_date' => 'required|date',
        ]);
        // dd($request->all());

        $students = DB::table('student_academic_histories')
                    ->join('students','student_academic_histories.user_id','=','students.user_id')
                    ->join('users','student_academic_histories.user_id','=','users.id')
                    ->select('student_academic_histories.user_id','students.first_name','students.last_name','student_academic_histories.roll','users.personnel_id')
                    ->whereNotIn('student_academic_histories.user_id',(DB::table('accounting_sinvoices')
                        ->select('accounting_sinvoices.user_id')
                        ->where('accounting_sinvoices.accounting_sfee_id',$request->fee_type_id)
                        ->where('accounting_sinvoices.due_date',$request->due_date)
                        ))
                    ->where('student_academic_histories.school_class_id',$request->school_class_id)
                    ->where('student_academic_histories.school_section_id',$request->school_section_id)
                    ->where('student_academic_histories.academic_year_id',$request->academic_year_id)
                    ->get();
                    // dd($students);
        if(count($students)<1){
            \Session::flash('flash_error','Fees already added');
            return redirect()->back();
        }

        $due_date = date('Y-m-d', strtotime($request->due_date));
        $accounting_sfee_id=(int)$request->fee_type_id;
        $academic_year_id=$request->academic_year_id;
        $school_class= SchoolClass::where('id',$request->school_class_id)->first();
        $school_section= SchoolSection::where('id',$request->section_id)->first();
        $academic_year= AcademicYear::where('id',$request->academic_year_id)->first();
        $student_fee = AccountingSfee::find($accounting_sfee_id);
        return view('assign_sFees.create',compact('students','due_date','academic_year_id', 'school_class','school_section','accounting_sfee_id','student_fee'));
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('AssignSfees'), redirect('error'));
        if (count($request->user_id)<1)
        {
            \Session::flash('flash_error','No Student Found');
            return redirect()->back();
        }

        foreach ($request['user_id'] as $sid) {
            $stuid[] = $sid;
        }
        foreach ($request['fee_amount'] as $feeamount) {
            $feeamounts[] = $feeamount;
        }

        $id = $stuid;
        $feeamount = $feeamounts;

        $count_ids = count($id);

        if (count($feeamount) != $count_ids) throw new Exception("Bad Request Input Array lengths");
        for ($i = 0; $i < $count_ids; $i++) {
            if (empty($id[$i])) continue; // skip all the blank ones
            $accounting_sinvoice = new AccountingSinvoice();
            $accounting_sinvoice->user_id = $id[$i];
            $accounting_sinvoice->fee_amount = $feeamount[$i];
            $accounting_sinvoice->accounting_sfee_id = $request->accounting_sfee_id;
            $accounting_sinvoice->academic_year_id = $request->academic_year_id;
            $accounting_sinvoice->due_date = date('Y-m-d', strtotime($request->due_date));
            $accounting_sinvoice->save();
        }
        \Session::flash('flash_success','Fees assigned successfully');
        return redirect('manage-assign-fees');
    }

    public function manage_assign_fees(){
        $academicYearId = sessionAcademicYearWithAll();
        $baseQuery = AccountingSinvoice::query()
                    ->with('accounting_sfee','user')
                    ->whereHas('user.student_academic_histories', function ($query) use ($academicYearId) {
                        if(is_array($academicYearId))
                            $query->whereIn('academic_year_id', $academicYearId);
                        else
                            $query->where('academic_year_id', $academicYearId);
                    });

        if(Auth::user()->user_type_id == 5){ // Guardian
            $childrens = getChildInfo();
            $userIds = collect($childrens)->pluck('user_id')->toArray();
            $baseQuery->whereIn('user_id', $userIds);
        } elseif(Auth::user()->user_type_id == 2){ // Student
            $baseQuery->where('user_id', Auth::user()->id);
        }
        $base = $baseQuery->get();
        $accounting_sinvoice = $base->sortByDesc('id');

        $student_unpaid = $base->filter(fn($item) => $item->is_status == 0)
                                ->sortByDesc('id')
                                ->values();

        $student_paid = $base->filter(fn($item) => $item->is_status == 1)
                                ->sortByDesc('id')
                                ->values();
        $total_fee_amount = $base->sum('collect_amount');
        $total_collection = $base->sum(function ($item) {
            return $item->collect_amount + $item->fine_amount - $item->discount_amount;
        });

        return view('assign_sFees.index', compact('accounting_sinvoice','student_unpaid','student_paid','total_fee_amount','total_collection'));
    }

    public function edit($id){
        abort_if(Gate::denies('EditAssignSfees'), redirect('error'));
        $data = AccountingSinvoice::findOrFail($id);
        if($data){
            return view('assign_sFees.edit', compact('data'));
        }
    }

    public function update(Request $request){
        abort_if(Gate::denies('EditAssignSfees'), redirect('error'));
        $data = AccountingSinvoice::findOrFail($request->id);
        if($data){
            $data->collect_amount = $request->collect_amount;
            $data->fine_amount = $request->fine_amount;
            $data->discount_amount = $request->discount_amount;
            $data->collect_date = date('Y-m-d', strtotime($request->collect_date));
            $data->is_status = $request->is_status;
            $data->update();
            \Session::flash('flash_success','Updated successfully added');
            return redirect('manage-assign-fees');
        }
    }

    public function destroy($id){
        abort_if(Gate::denies('DeleteAssignSfees'), redirect('error'));
       $data = AccountingSinvoice::findOrFail($id);
       $data->delete();
       if($data){
        \Session::flash('flash_success','Fees deleted added');
       }else{
        \Session::flash('flash_error','Something went wrong. Try later.');
       }
        return redirect()->back();
    }
}
