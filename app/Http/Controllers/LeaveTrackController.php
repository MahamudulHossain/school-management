<?php

namespace App\Http\Controllers;

use App\Models\LeaveTrack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\LeaveTrackCreateRequest;

class LeaveTrackController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        abort_if(Gate::denies('ManageLeave'), redirect('error'));
        $activeTab = '';
        if(Auth::user()->user_type_id == 3){ // Teacher
            $leave_all = LeaveTrack::with(['leave_type', 'user'])
                            ->whereHas('user', function ($query) {
                                $query->where(['id'=>Auth::user()->id,'user_type_id'=>3])->orWhere('user_type_id',2);
                            })->get();
            $activeTab = 'teacher';
        }elseif(in_array(Auth::user()->user_type_id,[2,5])){ // Student and Guardian
            if(Auth::user()->user_type_id == 2){ // Student
                $leave_all = LeaveTrack::with(['leave_type', 'user'])
                            ->whereHas('user', function ($query) {
                                $query->where(['id'=>Auth::user()->id,'user_type_id'=>2]);
                            })->get();
            }else{ // Guardian
                $children = getChildInfo();
                foreach($children as $child){
                    $userIds[] = $child->user_id;
                }
                $leave_all = LeaveTrack::with(['leave_type', 'user'])
                            ->whereHas('user', function ($query) use($userIds) {
                                $query->whereIn('id',$userIds);
                            })->get();
            }
            $activeTab = 'student';
        }
        else{
            $leave_all = LeaveTrack::with(['leave_type','user'])->get();
            $activeTab = 'teacher';
        }
        return view ('leave_track.index',compact('leave_all','activeTab'));
    }

    public function create(){
        abort_if(Gate::denies('CreateLeave'), redirect('error'));
        $leave_types = DB::table('leave_types')->pluck('leave_type_name','id');
        return view('leave_track.create',compact('leave_types'));
    }

    public function auto_user_leave()
    {
        if (!empty($_POST['type'])) {
            $type = $_POST['type'];
            $name = $_POST['name_startsWith'];

            // Subqueries for each group

            $students = DB::table('students')
                ->select('first_name', 'middle_name', 'last_name', 'user_id', 'id');

            if(in_array(Auth::user()->user_type_id,[2,5])){ // Student and Guardian
                $students = DB::table('students')->join('users','users.id','=','students.user_id');
                if(Auth::user()->user_type_id == 2){ // Student
                    $students = $students->where('users.id',Auth::user()->id);
                }else{ // Guardian
                    $children = getChildInfo();
                    foreach($children as $child){
                        $userIds[] = $child->user_id;
                    }
                    $students = $students->whereIn('users.id',$userIds);
                }
                $students = $students->select(
                                    'students.first_name',
                                    'students.middle_name',
                                    'students.last_name',
                                    'students.user_id',
                                    'students.id'
                                );
            }

            if(Auth::user()->user_type_id == 3){ // Teacher
                $teachers = DB::table('teachers')
                            ->join('users','users.id','=','teachers.user_id')
                            ->where('users.id',Auth::user()->id)
                            ->select(
                                'teachers.first_name',
                                'teachers.middle_name',
                                'teachers.last_name',
                                'teachers.user_id',
                                'teachers.id'
                            );
            }

            if(Auth::user()->can('ManageEmployeeLeave')){
                $teachers = DB::table('teachers')
                ->select('first_name', 'middle_name', 'last_name', 'user_id', 'id');

                $employees = DB::table('employees')->select('first_name', 'middle_name', 'last_name', 'user_id', 'id');
                $unionQuery = $students->union($teachers)->union($employees);
            }elseif(Auth::user()->user_type_id == 3){
                $unionQuery = $students->union($teachers);
            }else{
                $unionQuery = $students;
            }



            // Use the union as a subquery
            $result = DB::query()
                ->fromSub($unionQuery, 'people')   // alias for the union result
                ->join('users', 'users.id', '=', 'people.user_id')
                ->select('people.first_name', 'people.middle_name', 'people.last_name', 'people.user_id', 'people.id', 'users.personnel_id')
                ->where($type, 'like', "%" . strtoupper($name) . "%")
                ->get();

            $data = [];
            foreach ($result as $value) {
                $name = $value->first_name. '|' . $value->middle_name. '|' . $value->last_name. '|' . $value->personnel_id. '|' . $value->id. '|' . $value->user_id;
                $data[] = $name;
            }

            echo json_encode($data);
            exit;

        }
    }

    public  function store(LeaveTrackCreateRequest $request){
        abort_if(Gate::denies('CreateLeave'), redirect('error'));
        LeaveTrack::create($request->all());
        \Session::flash('flash_message','Successfully Added');
        return redirect('leave-track');
    }

    public function edit(LeaveTrack $leave_track)
    {
        abort_if(Gate::denies('ManageLeave'), redirect('error'));
        if($leave_track->status != 'applied' && in_array(Auth::user()->user_type_id,[2,5])){ // Student and Guardina
            return redirect('/error');
        }
        if($leave_track->status != 'applied' && Auth::user()->user_type_id == 3){ // Teacher
            return redirect('/error');
        }
        $leave_types = DB::table('leave_types')->pluck('leave_type_name','id');
        return view('leave_track.edit',compact('leave_track','leave_types'));
    }

    public function update(LeaveTrackCreateRequest $request, LeaveTrack $leave_track)
    {
        abort_if(Gate::denies('ManageLeave'), redirect('error'));
        $leave_track->update($request->all());
        \Session::flash('flash_message','Successfully Updated');
        return redirect('leave-track');
    }

    public function destroy(LeaveTrack $leave_track)
    {
        $leave_track->delete();
        \Session::flash('flash_message','Successfully Deleted');
        return redirect('leave-track');
    }

}
