<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\EmployeePresence;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class EmployeePresenceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        abort_if(Gate::denies('EmployeeAccess'), redirect('error'));
        $t_presence = DB::table('employee_presences')
          ->select('date')
          ->distinct()
          ->orderBy('date', 'desc')
          ->get();
        return view('employee_presence.index',compact('t_presence'));
    }

    public function create(){
        abort_if(Gate::denies('EmployeePresenceCreate'), redirect('error'));
        $employees = User::whereHas('employee', function($query) {
                        $query->where('status', 'active');
                    })
                    ->with('employee')
                    ->get();
        return view('employee_presence.create', compact('employees'));
    }

    public function store(Request $request){
        abort_if(Gate::denies('EmployeePresenceCreate'), redirect('error'));
        $this->validate($request, [
            'date' => 'required|date',
        ]);
        $date = date('Y-m-d', strtotime($request->date));

        // Check if attendance already exists for this date
        if (EmployeePresence::where('date', $date)->exists()) {
            return redirect('employee_presence')
                ->withErrors(['time' => 'Attendance for this date already exists. Please modify it instead.']);
        }

        $attendanceData = [];
        foreach ($request->user_id as $index => $userId) {
            if (empty($userId)) continue;

            $attendanceData[] = [
                'user_id' => $userId,
                'in_time' => $request->in_time[$index] ? date('H:i:s', strtotime($request->in_time[$index])) : NULL,
                'out_time' => $request->out_time[$index] ? date('H:i:s', strtotime($request->out_time[$index])) : NULL,
                'remarks' => $request->remarks[$index],
                'date' => $date,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        if (!empty($attendanceData)) {
            EmployeePresence::insert($attendanceData);
        }

        \Session::flash('flash_message', 'Successfully Added');
        return redirect('employee_presence');
    }

    public function show($date)
    {
        abort_if(Gate::denies('EmployeeAccess'), redirect('error'));
        $date_presence = EmployeePresence::where('date',$date)->get();
        return view('employee_presence.show',compact('date_presence','date'));
    }

    public function edit($date){
        abort_if(Gate::denies('EmployeePresenceCreate'), redirect('error'));
        $date_presence = EmployeePresence::where('date',$date)->get();
        return view('employee_presence.edit',compact('date_presence','date'));
    }

    public function update(Request $request, $date){
        abort_if(Gate::denies('EmployeePresenceCreate'), redirect('error'));

        foreach ($request['user_id'] as $sid) {
            $stuid[] = $sid ;        }
        foreach ($request['in_time'] as $it) {
            $int[] = $it ;        }
        foreach ($request['out_time'] as $ot) {
            $out[] = $ot ;        }
        foreach ($request['remarks'] as $rem) {
            $remar[] = $rem ;        }

        $id=$stuid;
        $in_t=$int;
        $out_t=$out;
        $re=$remar;
        $count_ids = count($id);
        if(count($id) != $count_ids) throw new Exception("Bad Request Input Array lengths");
        for($i = 0; $i < $count_ids; $i++){
            if (empty($id[$i])) continue; // skip all the blank ones

             DB::table('employee_presences')->where('user_id', '=', $id[$i])
                 ->where('date',$date)
                ->update(
                    array(
                        'in_time' => $in_t[$i] ? date('H:i:s ',strtotime($in_t[$i])) : NULL,
                        'out_time' => $out_t[$i] ? date('H:i:s ',strtotime($out_t[$i])) : NULL,
                        'remarks' => $re[$i]
                        )
                    );
        }
        \Session::flash('flash_message', 'Successfully Added');
        return redirect('employee_presence');
    }

    public function employee_presence_report(){
        abort_if(Gate::denies('EmployeeAttendanceReportAccess'), redirect('error'));
        $employees = User::whereHas('employee', function($query) {
                        $query->where('status', 'active');
                    })
                    ->with('employee')
                    ->get();
        return view('employee_presence.employee_presence_report', compact('employees'));
    }

    public function employee_attendance_reportbyrange(Request $request){
        $this->validate($request, [
            'date_range' => 'required ',
        ]);
        [$from, $to] = explode(' - ', $request->date_range);
        $attendance_employees = EmployeePresence::whereBetween('date',[$from,$to])->orderBy('date','desc')->get();
        return view('employee_presence.report_datewise', compact('attendance_employees'));
    }

    public function attendance_report_byemployee(Request $request){
        $this->validate($request, [
            'user_id' => 'required ',
            'date_range' => 'required ',
        ]);
        [$from, $to] = explode(' - ', $request->date_range);
        $attendance_employee = EmployeePresence::where('user_id',$request->user_id)->whereBetween('date',[$from,$to])->orderBy('date','desc')->get();
        $employeeName = count($attendance_employee) ? $attendance_employee[0]->user->employee->first_name.' '.$attendance_employee[0]->user->employee->middle_name.' '.$attendance_employee[0]->user->employee->last_name.' ('. $attendance_employee[0]->user->personnel_id .')' : '';
        return view('employee_presence.report_byemployee', compact('attendance_employee','employeeName'));
    }
}
