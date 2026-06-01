<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Guardian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        abort_if(Gate::denies('StudentAccess'), redirect('error'));
        $academicYearId = sessionAcademicYearWithAll();
        $students = User::with(['roles',
                                'user_type',
                                'student',
                                'student_academic_histories.student_class',
                                'student_academic_histories.student_section',
                                'profile',
                                'imageprofile'
                            ])
                            ->whereHas('student_academic_histories', function ($query) use ($academicYearId) {
                                if(is_array($academicYearId))
                                    $query->whereIn('academic_year_id', $academicYearId);
                                else
                                    $query->where('academic_year_id', $academicYearId);
                            })
                            ->where('user_type_id',2);
        if(Auth::user()->user_type_id == 5){ // Guardian
            $children = getChildInfo();
            foreach($children as $child){
                $userIds[] = $child->user_id;
            }
            $students = $students->whereIn('id',$userIds)->orderBy('id','desc')->get();
        }elseif(Auth::user()->user_type_id == 2){ // Student
            $students = $students->where('id',Auth::user()->id)->orderBy('id','desc')->get();
        }else{
            $students = $students->orderBy('id','desc')->get();
        }
        return view('students.index',compact('students'));
    }

    public function personal_profile_update(Request $request, $id)
    {
        abort_if(Gate::denies('StudentEdit'), redirect('error'));
        $input = $request->all();
        $student = Student::findOrFail($id);
        // Update personnel_id
        $user = User::find($student->user_id);
        // dd($user);
        if(isset($input['personnel_id'])){
            DB::table('users')->where('id',$student->user_id)->update([
                'personnel_id'=>$input['personnel_id']
            ]);
        }

        unset($input['personnel_id']);
        $student->update($input);

        \Session::flash('flash_success', 'Student Profile updated successfully');
        return redirect()->back();
    }

    public function guardian_profile_update(Request $request, $id)
    {
        $guardian = Guardian::findOrFail($id);
        $guardian->update($request->all());

        \Session::flash('flash_success', 'Student Guardian Profile updated successfully');
        return redirect()->back();
    }

    public function attendant_profile_update(Request $request, $id)
    {
        abort_if(Gate::denies('StudentAttendantUpdate'), redirect('error'));
        $attendant = DB::table('attendant_student')->where('student_id',$id)->first();
        if($attendant){
            DB::table('attendant_student')->where('student_id',$id)->update([
                'attendant_id'=> $request->attendant_id
            ]);
        }else{
            DB::table('attendant_student')->insert([
                'attendant_id'=> $request->attendant_id,
                'student_id'=> $id
            ]);
        }
        \Session::flash('flash_success', 'Student Attendant Profile updated successfully');
        return redirect()->back();
    }

}
