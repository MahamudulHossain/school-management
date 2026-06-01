<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use App\Models\Guardian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GuardianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        abort_if(Gate::denies('StudentAccess'), redirect('error'));
        $students = User::with(['student','profile','imageprofile'])->where('user_type_id',3)->orderBy('id','desc')->get();
        return view('students.index',compact('students'));
    }

    public function personal_profile_update(Request $request, $user_id)
    {
        $guardian = Contact::where('user_id', $user_id)->first();
        // dd($request->all());
        if(isset($request->present_permanent) && $request->present_permanent == '1') {
            $guardian->pre_house = $guardian->per_house = $request->pre_house;
            $guardian->pre_road = $guardian->per_road = $request->pre_road;
            $guardian->pre_state = $guardian->per_state = $request->pre_state;
            $guardian->pre_post = $guardian->per_post = $request->pre_post;
            $guardian->pre_thana = $guardian->per_thana = $request->pre_thana;
            $guardian->pre_district = $guardian->per_district = $request->pre_district;
            $guardian->pre_division = $guardian->per_division = $request->pre_division;
            $guardian->pre_country = $guardian->per_country = $request->pre_country;
            $guardian->present_permanent = 1;
        }else{
            $guardian->pre_house = $request->pre_house;
            $guardian->pre_road = $request->pre_road;
            $guardian->pre_state = $request->pre_state;
            $guardian->pre_post = $request->pre_post;
            $guardian->pre_thana = $request->pre_thana;
            $guardian->pre_district = $request->pre_district;
            $guardian->pre_division = $request->pre_division;
            $guardian->pre_country = $request->pre_country;
            $guardian->present_permanent = 0;
            $guardian->per_house = $request->per_house;
            $guardian->per_road = $request->per_road;
            $guardian->per_state = $request->per_state;
            $guardian->per_post = $request->per_post;
            $guardian->per_thana = $request->per_thana;
            $guardian->per_district = $request->per_district;
            $guardian->per_division = $request->per_division;
            $guardian->per_country = $request->per_country;
        }
        $guardian->save();

        \Session::flash('flash_success', 'Guardian Profile updated successfully');
        return redirect()->back();
    }

    public function guardian_list(){
        abort_if(Gate::denies('GuardianAccess'), redirect('error'));
        $academicYearId = sessionAcademicYearWithAll();
        $base = User::with([
            'roles','guardian','user_type','profile','imageprofile'
            ])
            ->whereHas('guardian.students.user.student_academic_histories', function($query) use ($academicYearId){
                if(is_array($academicYearId))
                    $query->whereIn('academic_year_id', $academicYearId);
                else
                    $query->where('academic_year_id', $academicYearId);
            })
            ->where('user_type_id',5)->orderBy('id','desc');
        $guardians = $base->get();
        return view('guardians.index', compact('guardians'));
    }

}
