<?php

namespace App\Http\Controllers;

use DB;
use DateTime;
use App\Models\Role;
use App\Models\User;
use App\Models\Contact;
use App\Models\Profile;
use App\Models\Setting;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Employee;
use App\Models\Guardian;
use App\Models\UserType;
use App\Models\Attendant;
use App\Models\SchoolClass;
use Illuminate\Support\Arr;
use App\Models\AcademicYear;
use App\Models\ImageProfile;
use Illuminate\Http\Request;
use App\Models\SchoolSection;
use App\Models\StudentGuardian;
use App\Models\AccountingSinvoice;
use App\Models\AccountingTransport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\StudentAcademicHistory;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use  \Redirect, \Validator, \Session, \Hash;
use Symfony\Component\HttpFoundation\Response;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->default_password = Setting::first()->default_password;
    }

    public function index()
    {
        abort_if(Gate::denies('UserAccess'), redirect('error'));
        if(Auth::user()->email == 'superadmin@eidyict.com')
            $users = User::with(['user_type','student','teacher','employee','guardian'])->get();
        elseif (in_array(Auth::user()->user_type_id, [1,4]) && Auth::user()->email != 'superadmin@eidyict.com'){
            $users = User::with(['user_type','student','teacher','employee','guardian'])->where('id', '>', '2')->get();
        }else
            $users = User::with(['user_type','student','teacher','employee','guardian'])->where('id', Auth::user()->id)->get();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('UserCreate'), redirect('error'));
        $user_types = UserType::where('status', 'Active')->get();
        return view('user.create', compact('user_types'));
    }

    public function teacher_create()
    {
        abort_if(Gate::denies('TeacherCreate'), redirect('error'));
        $roles = Role::all();
        $academic_year = DB::table('academic_years')->pluck('title','id');
        return view('user.teacher_create',compact('roles','academic_year'));
    }

    public function employee_create()
    {
        abort_if(Gate::denies('EmployeeCreate'), redirect('error'));
        $roles = Role::all();
        $academic_year = DB::table('academic_years')->pluck('title','id');
        return view('user.employee_create',compact('roles','academic_year'));
    }

    public function student_create()
    {
        abort_if(Gate::denies('StudentCreate'), redirect('error'));
        $roles = Role::all();
        $school_classes = DB::table('school_classes')->orderBy('numeric_no','asc')->pluck('class_name','id');
        $school_sections = DB::table('school_sections')->orderBy('priority_no','asc')->pluck('section_name','id');
        $academic_years = DB::table('academic_years')->orderBy('id','desc')->pluck('title','id');
        $guardians = Guardian::with('user')->where('status','active')->get();
        $attendants = Attendant::all();
        $sessionAcademicYear = getSessionAcademicYear();
        return view('user.student_create',compact('roles','school_classes','school_sections','academic_years','guardians','attendants','sessionAcademicYear'));
    }

    public function store(UserCreateRequest $request)
    {
        abort_if(Gate::denies('UserCreate'), redirect('error'));

        DB::beginTransaction(); // Start transaction

        try {
            $personnel_id = NULL;
            if($request->user_type== 2){ //Student
                $personnel_id = $this->createPersonnelId('S');
            }
            if ($request->user_type== 3){ // Teacher
                $personnel_id = $this->createPersonnelId('T');
            }elseif ($request->user_type== 4){ // Employee
                $personnel_id = $this->createPersonnelId('E');
            }
            // dd($personnel_id);

                $user = new User;
                $user->name = $request->name ?? NULL;
                $user->email = $request->email ?? NULL;
                $user->cell_phone = $request->cell_phone ?? NULL;
                $user->password = bcrypt($request->password ?? '123456');
                $user->user_type_id = $request->user_type;
                $user->web_access = $request->web_access ?? 0;
                $user->personnel_id = $personnel_id ?? NULL;
                $user->save();

                $profile = new Profile();
                $profile->user_id = $user->id;
                $profile->gender = $request->gender;
                $profile->save();

                $image_profile = new ImageProfile();
                $image_profile->user_id = $user->id;
                $image_profile->save();

                // $role_ids = $request->user_type;
                // $user->roles()->attach($role_ids);
                $user->roles()->sync($request->input('roles', []));

                if ($request->user_type==2){ //Student
                    //Student
                    $student= new Student();
                    $student->user_id=$user->id;
                    $student->first_name=$request->first_name;
                    $student->middle_name=$request->middle_name ?? NULL;
                    $student->last_name=$request->last_name ?? NULL;
                    $student->save();

                    $user->name = $request->first_name.' '.$request->middle_name.' '.$request->last_name;
                    $user->save();

                    // Guardian
                    if(isset($request->guardian_id)){
                        $guardian_id = $request->guardian_id;
                    }elseif($request->guardian_email || $request->guardian_cell_phone){ // New guardian

                        $user_guardian = new User();
                        $user_guardian->password=bcrypt(123456);
                        $user_guardian->user_type_id=5;
                        $user_guardian->email=$request->guardian_email ?? NULL;
                        $user_guardian->cell_phone = $request->guardian_cell_phone ?? NULL;
                        $user_guardian->web_access=1;
                        $user_guardian->personnel_id = $this->createPersonnelId('G');
                        $user_guardian->save();
                        $user_guardian->roles()->sync(5);


                        $guardian_profile = new Profile();
                        $guardian_profile->user_id = $user_guardian->id;
                        $guardian_profile->gender = $request->gender;
                        $guardian_profile->save();

                        $guardian_image_profile = new ImageProfile();
                        $guardian_image_profile->user_id = $user_guardian->id;
                        $guardian_image_profile->save();

                        $guardian=new Guardian();
                        $guardian->user_id=$user_guardian->id;
                        $guardian->save();

                        $guardian_contract=new Contact();
                        $guardian_contract->user_id=$user_guardian->id;
                        $guardian_contract->save();

                        $guardian_id = $guardian->id;
                    }

                    // Student Guardian pivot table
                    $sg = new StudentGuardian();
                    $sg->student_id = $student->id;
                    $sg->guardian_id = $guardian_id;
                    $sg->save();

                    // Attendant
                        if(isset($request->attendant_id)){
                            $attendant = Attendant::find($request->attendant_id);
                        }elseif($request->attendant_name || $request->attendant_cell_phone){ // New Attendant
                            $this->validate($request, [
                                'attendant_name' => 'required',
                                'attendant_cell_phone' => [
                                    'required',
                                    'regex:/^\+\d{13}$/',
                                    'unique:attendants,contact_no',
                                ]
                            ]);
                            $attendant = Attendant::create([
                                'name' => $request->attendant_name,
                                'contact_no' => $request->attendant_cell_phone
                            ]);
                        }


                        if(isset($attendant)){
                            // Student Attendant pivot table
                            $attendant->students()->sync($student->id);
                        }

                    //Student Academic History
                    $sah_profile=new StudentAcademicHistory();
                    $sah_profile->user_id=$user->id;
                    $sah_profile->academic_year_id =$request->academic_year_id;
                    $sah_profile->school_class_id =$request->school_class_id;
                    $sah_profile->school_section_id =$request->school_section_id;
                    $sah_profile->roll=$request->roll;
                    $sah_profile->save();

                }elseif ($request->user_type==3){ //Teacher
                    $teacher=new Teacher();
                    $teacher->user_id=$user->id;
                    $teacher->save();
                }elseif ($request->user_type==4){ //Employee
                    $employee=new Employee();
                    $employee->user_id=$user->id;
                    $employee->save();
                }
            DB::commit();

            \Session::flash('flash_message', 'Successfully Added');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback on error
            return back()->withInput()->with('error', 'Error: '.$e->getMessage());
        }


        return redirect('user/'.$user->id);
    }


    public function show(User $user)
    {
        abort_if(Gate::denies('UserAccess'), redirect('error'));

        if ($user->id == 1 && Auth::user()->id != 1) {
            \Session::flash('flash-error', 'You cannot view Admin ');
            return \Redirect::to('user');
        }

        if(Auth::user()->user_type_id == 2 && $user->id != Auth::user()->id){
            return \Redirect::to('user');
        }

        if(Auth::user()->user_type_id == 4 && $user->id != Auth::user()->id){
            return \Redirect::to('user');
        }

        $user_name = '';
        $stu_aca_his = [];
        $attachedGuardian = [];
        $attachedAttendant = [];
        $attendants = [];
        $attendantInfo = null;
        $studentLedger = (object) [];
        $students = collect();
        if ($user->user_type_id == 1)
            $user_type = 'Admin';
        else if ($user->user_type_id == 2){ // Student
            $user_name = Student::where('user_id',$user->id)->first();
            $stu_aca_his= StudentAcademicHistory::where('user_id',$user->id)->orderBy('academic_year_id','DESC')->get();
            $attachedGuardian = StudentGuardian::with(['students','guardian.user'])->where('student_id',$user_name->id)->first();
            $attachedAttendant = DB::table('attendant_student')->where('student_id',$user_name->id)->first();
            $attendants = Attendant::all();
            if($attachedAttendant){
                $attendantInfo = Attendant::find($attachedAttendant->attendant_id);
            }
            $studentLedger = $this->studentLedger($user->id);
            $user_type = 'Student';
        }else if ($user->user_type_id == 3){ // Teacher
            $user_name = Teacher::where('user_id',$user->id)->first();
            $user_type = 'Teacher';
        }else if ($user->user_type_id == 4){ // Employee
            $user_name = Employee::where('user_id',$user->id)->first();
            $user_type = 'Employee';
        }else if ($user->user_type_id == 5){ // Guardian
            $guardian = Guardian::where('user_id',$user->id)->first();
            $children = StudentGuardian::where('guardian_id',$guardian->id)->get();
            foreach($children as $st){
                $studentInfo[] = Student::where('id',$st->student_id)->first();
            }
            foreach($studentInfo as $child){
                $userIds[] = $child->user_id;
            }
            $students = User::with(['roles',
                                'user_type',
                                'student',
                                'student_academic_histories.student_class',
                                'student_academic_histories.student_section',
                                'profile',
                                'imageprofile'
                                ])->where('user_type_id',2);
            $students = $students->whereIn('id',$userIds)->orderBy('id','desc')->get();
            $user_type = 'Guardian';
        }else if ($user->user_type_id == 6)
            $user_type = 'Visitor';

        $title_date_range=$user->name;
        return view('user.show_sc', compact('user','user_type','title_date_range','user_name','stu_aca_his','attachedGuardian','attachedAttendant','attendants','attendantInfo','studentLedger','students'));
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('UserAccess'), redirect('error'));

        if ($user->id < 2 && Auth::user()->id != 1) {
            \Session::flash('flash-error', 'You cannot edit System admin ');
            return \Redirect::to('user');
        }else if($user->id > 2 && Auth::user()->user_type_id == 5 && $user->id != Auth::user()->id){ // Guardian editing student
            $childrens = getChildInfo();
            foreach($childrens as $child){
                $userIds[] = $child->user_id;
            }
            if(in_array($user->id,$userIds))
                $user = User::find($user->id);
            else{
                return redirect()->back();
            }
        }else if ($user->id > 2 && Auth::user()->user_type_id != 1 && Auth::user()->id == $user->id) { // User himself logged In
           $user = User::find(Auth::user()->id);
        }else if (in_array(Auth::user()->user_type_id, [1,4])) { // Admin & Employee
            $user = User::find($user->id);
        }else{
            \Session::flash('flash-error', 'You cannot edit this user');
            return \Redirect::to('user');
        }

        if (Auth::user()->email == 'superadmin@eidyict.com')
            $roles = Role::pluck('title', 'id');
        else
            $roles = Role::where('title', '!=', 'Super Admin')->pluck('title', 'id');
        $user_types = UserType::get();
        $blood_groups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        $religions = ['Islam', 'Hindu', 'Christian', 'Buddhist', 'Other'];
        $maritial_statuses = ['Married', 'Unmarried', 'Divorced', 'Widowed'];


        if($user->user_type_id == 2){ // Student
            $student = Student::where('user_id',$user->id)->first();
            $stu_aca_his = [];
            $stu_aca_his= StudentAcademicHistory::where('user_id',$user->id)->orderBy('academic_year_id','DESC')->get();
            $academic_year = AcademicYear::pluck('title', 'id');
            $schoolClass = SchoolClass::pluck('class_name', 'id');
            $schoolSection = SchoolSection::orderBy('priority_no','asc')->pluck('section_name', 'id');
            $attachedGuardian = StudentGuardian::with(['students','guardian.user'])->where('student_id',$student->id)->first();
            $attachedAttendant = DB::table('attendant_student')->where('student_id',$student->id)->first();
            $attendantInfo = null;
            $attendants = Attendant::all();
            if($attachedAttendant){
                $attendantInfo = Attendant::find($attachedAttendant->attendant_id);
            }
             return view('user.edit', compact('user', 'roles', 'user_types', 'blood_groups', 'religions', 'maritial_statuses', 'stu_aca_his', 'academic_year', 'schoolClass', 'schoolSection', 'attachedGuardian','attendantInfo','attendants'));
        }else{
            return view('user.edit', compact('user', 'roles', 'user_types', 'blood_groups', 'religions', 'maritial_statuses'));
        }


    }

    public function update(User $user, UserUpdateRequest $request)
    {
        // dd($user,$request->all());
        abort_if(Gate::denies('UserAccess'), redirect('error'));
        if ($user->id == 1 && Auth::user()->id != 1) {
            \Session::flash('flash_error', 'You cannot edit Super Admin ');
            return \Redirect::to('user');
        } else {

            $input = $request->all();

            if (!empty($input['password'])) {
                $this->validate($request, [
                    'password' => ['required',
                        'min:6',
                        'same:password_confirmation'],
                    'password_confirmation' => 'required',
                ]);
                $input['password'] = bcrypt($input['password']);
            } else {
                unset($input['password']);
            }

            $user = User::find($user->id);
        //    dd($user,$input);
            $user->update($input);
            $user->roles()->sync($request->input('roles', []));

            \Session::flash('flash_success', 'User updated successfully');
            return redirect('user/' . $user->id);

        }
    }

    public function destroy(User $user)
    {

        abort_if(Gate::denies('UserDelete'), redirect('error'));
        if ($user->id == 1 && Auth::user()->id != 1) {
            Session::flash('flash-error', 'You cannot delete Super admin ');
            return redirect('user');
        } else {
            $user_type=$user->user_type->id;

            $user->delete();
            \Session::flash('flash_message', 'Successfully Deleted');

            if ($user_type == 1 || Auth::user()->user_type_id == 1)
                return redirect('user');
        }
    }

    public function myprofile()
    {
        $user = \Auth::user();

        $user_name = (object) [];
        $user_name->first_name = '';
        $stu_aca_his = [];
        $attachedGuardian = [];
        $attachedAttendant = [];
        $attendants = [];
        $attendantInfo = null;
        $studentLedger = (object) [];
        $students = collect();
        if ($user->user_type_id == 1)
            $user_type = 'Admin';
        else if ($user->user_type_id == 2){ // Student
            $user_name = Student::where('user_id',$user->id)->first();
            $stu_aca_his= StudentAcademicHistory::where('user_id',$user->id)->orderBy('academic_year_id','DESC')->get();
            $attachedGuardian = StudentGuardian::with(['students','guardian.user'])->where('student_id',$user_name->id)->first();
            $attachedAttendant = DB::table('attendant_student')->where('student_id',$user_name->id)->first();
            $attendants = Attendant::all();
            if($attachedAttendant){
                $attendantInfo = Attendant::find($attachedAttendant->attendant_id);
            }
            $studentLedger = $this->studentLedger($user->id);
            $user_type = 'Student';
        }else if ($user->user_type_id == 3){ // Teacher
            $user_name = Teacher::where('user_id',$user->id)->first();
            $user_type = 'Teacher';
        }else if ($user->user_type_id == 4){ // Employee
            $user_name = Employee::where('user_id',$user->id)->first();
            $user_type = 'Employee';
        }else if ($user->user_type_id == 5){ // Guardian
            $guardian = Guardian::where('user_id',$user->id)->first();
            $children = StudentGuardian::where('guardian_id',$guardian->id)->get();
            foreach($children as $st){
                $studentInfo[] = Student::where('id',$st->student_id)->first();
            }
            foreach($studentInfo as $child){
                $userIds[] = $child->user_id;
            }
            $students = User::with(['roles',
                                'user_type',
                                'student',
                                'student_academic_histories.student_class',
                                'student_academic_histories.student_section',
                                'profile',
                                'imageprofile'
                                ])->where('user_type_id',2);
            $students = $students->whereIn('id',$userIds)->orderBy('id','desc')->get();
            $user_type = 'Guardian';
        }
    //    dd($stu_aca_his);
        $title_date_range='Show User';
        return view('user.show_sc', compact('user','user_name','user_type','title_date_range','stu_aca_his','attachedGuardian','attachedAttendant','attendants','attendantInfo','studentLedger','students'));
    }

    //By selfUser
    public function password_update(Request $request)
    {
//        dd($request);
        $this->validate($request, [
            'current_password' => 'required',
            'new_password' => ['required',
                'min:6',
//                'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!@#$%^&*_]).*$/',
                'different:current_password'],
            'confirm_password' => 'required|same:new_password',
        ]);
        $data = $request->all();
        $user = User::find(auth()->user()->id);
//        dd($user);
        if (!Hash::check($data['current_password'], $user->password)) {
//            dd('not match');
            \Session::flash('flash_error', 'Current password does not match the system.');
            return back();
        } else {
//            dd('match');
            $input = $request->all();
            $input['password'] = bcrypt($request['new_password']);
            $user->update($input);

            \Session::flash('flash_success', 'Password updated successfully');
            return redirect('/myprofile');
        }
    }

    public function select_user_action(Request $request)
    {
        if ($request->ajax()) {
            $row_id = $request->main_action;
            $data = view('user.select_user_action', compact('row_id'))->render();
            return response()->json(['options' => $data]);
        }
    }

    private function createPersonnelId($utype){
        return $utype.'-' . round(microtime(true) * 1000);
    }

    private function studentLedger($userId){
        $accounting_sinvoices = AccountingSinvoice::with('accounting_sfee')
                                ->where('user_id',$userId)
                                ->orderBy('created_at','desc');
        if(session()->get('acad_year') != 'all')
            $accounting_sinvoices = $accounting_sinvoices->whereYear('created_at',session()->get('acad_year'));

        $accounting_sinvoices = $accounting_sinvoices->get();
        // dd($accounting_sinvoices);

        // Transaport
        $accounting_transports = AccountingTransport::query()
                                ->where('user_id',$userId)
                                ->orderBy('created_at','desc');
        if(session()->get('acad_year') != 'all')
            $accounting_transports = $accounting_transports->whereYear('created_at',session()->get('acad_year'));

        $accounting_transports = $accounting_transports->get();

        $merged_invoices = $accounting_sinvoices->merge($accounting_transports);

        // Sort the merged collection by the 'created_at' property in descending order.
        // The ->values() method is used to reset the array keys after sorting.
        $all_accounting_records = $merged_invoices->sortByDesc('created_at')->values();

        return $all_accounting_records;
    }


}
