<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TeacherPresence;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TeacherPresenceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        abort_if(Gate::denies('TeacherAttendance'), redirect('error'));
        if(Auth::user()->user_type_id == 3){ // Teacher
            $t_presence = DB::table('teacher_presences')
            ->join('users','users.id','=','teacher_presences.user_id')
            ->select('date')
            ->where('users.id',Auth::user()->id)
            ->distinct()
            ->orderBy('date', 'desc')
            ->get();
        }else{
            $t_presence = DB::table('teacher_presences')
            ->select('date')
            ->distinct()
            ->orderBy('date', 'desc')
            ->get();
        }
        return view('teacher_presence.index',compact('t_presence'));
    }

    public function create(){
        abort_if(Gate::denies('TeacherPresenceCreate'), redirect('error'));
        if(Auth::user()->user_type_id == 3){ // Teacher
            $teachers = User::whereHas('teacher', function($query) {
                        $query->where('status', 'active');
                    })
                    ->where('id',Auth::user()->id)
                    ->with('teacher')
                    ->get();
        }else{
            $teachers = User::whereHas('teacher', function($query) {
                        $query->where('status', 'active');
                    })
                    ->with('teacher')
                    ->get();
        }

        return view('teacher_presence.create', compact('teachers'));
    }

    public function store(Request $request){
        abort_if(Gate::denies('TeacherPresenceCreate'), redirect('error'));
        $this->validate($request, [
            'date' => 'required|date',
        ]);
        $date = date('Y-m-d', strtotime($request->date));

        // Check if attendance already exists for this date
        if (TeacherPresence::where('date', $date)->exists()) {
            return redirect('teacher_presence')
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
            TeacherPresence::insert($attendanceData);
        }

        \Session::flash('flash_message', 'Successfully Added');
        return redirect('teacher_presence');
    }

    public function show($date)
    {
        abort_if(Gate::denies('TeacherPresenceCreate'), redirect('error'));
        if(Auth::user()->user_type_id == 3){ // Teacher
            $date_presence = TeacherPresence::whereHas('user', function($query) {
                            $query->where('id', Auth::user()->id);
                        })->where('date',$date)->get();
        }else{
        $date_presence = TeacherPresence::where('date',$date)->get();
        }
        return view('teacher_presence.show',compact('date_presence','date'));
    }

    public function edit($date){
        abort_if(Gate::denies('TeacherPresenceUpdate'), redirect('error'));
        $date_presence = TeacherPresence::where('date',$date)->get();
        return view('teacher_presence.edit',compact('date_presence','date'));
    }

    public function update(Request $request, $date){
        abort_if(Gate::denies('TeacherPresenceUpdate'), redirect('error'));
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

             DB::table('teacher_presences')->where('user_id', '=', $id[$i])
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
        return redirect('teacher_presence');
    }

    public function teacher_presence_report(){
        abort_if(Gate::denies('TeacherAttendanceReportAccess'), redirect('error'));
        $teachers = User::whereHas('teacher', function($query) {
                        $query->where('status', 'active');
                    })
                    ->with('teacher');
        if(Auth::user()->user_type_id == 3){ // Teacher
            $teachers = $teachers->where('id', Auth::user()->id);
        }
        $teachers = $teachers->get();
        return view('teacher_presence.teacher_presence_report', compact('teachers'));
    }

    public function teacher_attendance_reportbyrange(Request $request){
        $this->validate($request, [
            'date_range' => 'required ',
        ]);
        [$from, $to] = explode(' - ', $request->date_range);
        $attendance_teachers = TeacherPresence::whereBetween('date',[$from,$to])->orderBy('date','desc');
        if(Auth::user()->user_type_id == 3){ // Teacher
            $attendance_teachers = $attendance_teachers->whereHas('user', function($query) {
                            $query->where('id', Auth::user()->id);
                        });
        }
        $attendance_teachers = $attendance_teachers->get();
        return view('teacher_presence.report_datewise', compact('attendance_teachers'));
    }

    public function attendance_report_byteacher(Request $request){
        $this->validate($request, [
            'user_id' => 'required ',
            'date_range' => 'required ',
        ]);
        [$from, $to] = explode(' - ', $request->date_range);
        $attendance_teacher = TeacherPresence::where('user_id',$request->user_id)->whereBetween('date',[$from,$to])->orderBy('date','desc')->get();
        $teacherName = count($attendance_teacher) ? $attendance_teacher[0]->user->teacher->first_name.' '.$attendance_teacher[0]->user->teacher->middle_name.' '.$attendance_teacher[0]->user->teacher->last_name.' ('. $attendance_teacher[0]->user->personnel_id .')' : '';
        return view('teacher_presence.report_byteacher', compact('attendance_teacher','teacherName'));
    }
}
