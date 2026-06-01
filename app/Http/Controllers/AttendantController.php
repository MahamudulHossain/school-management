<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Attendant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class AttendantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        abort_if(Gate::denies('ManageAttendant'), redirect('error'));
        $attendants = Attendant::orderBy('id', 'desc')->get();
        return view('attendant.index', compact('attendants'));
    }

    public function attached_list($attendant_id){
        abort_if(Gate::denies('ManageAttendant'), redirect('error'));
        $attendantInfo = Attendant::findOrFail($attendant_id);
        $attachedList = DB::table('attendant_student')->where('attendant_id',$attendant_id)->get();
        $studenInfo = [];
        if(count($attachedList)){
            foreach($attachedList as $aList){
                $studentInfo = Student::with('user','user.student_academic_histories','user.student_academic_histories.academic_year')->where('id',$aList->student_id)->first();
                $arr['name'] = $studentInfo->first_name.' '.$studentInfo->middle_name.' '.$studentInfo->last_name;
                $arr['p_id'] = $studentInfo->user->personnel_id;
                $arr['acad_year'] = $studentInfo->user->student_academic_histories->last()->academic_year->title;
                $arr['school_class'] = $studentInfo->user->student_academic_histories->last()->student_class->class_name;
                $arr['school_section'] = $studentInfo->user->student_academic_histories->last()->student_section->section_name;
                array_push($studenInfo,$arr);
            }
        }
        $title = 'Attached Students List of '.$attendantInfo->name;
        return view('attendant.list',compact('title','studenInfo'));
    }

    public function create()
    {
        abort_if(Gate::denies('ManageAttendant'), redirect('error'));
        return view('attendant.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'contact_no' => [
                'required',
                'regex:/^\+\d{13}$/',
                'unique:attendants,contact_no',
            ],
            'image' => 'mimes:png,jpeg,jpg,bmp | max:1024'
        ]);

        $newAttendant = Attendant::create($request->all());
        $image = $request->file('image');

        if(isset($image)){
            $slug = 'ip';
            $profile_img = Attendant::find($newAttendant->id);
            $utime = round(microtime(true) * 1000);
            $imagename = $slug . '-' . $utime . '.' . $image->getClientOriginalExtension();
            if (!Storage::disk('public')->exists('image_profile')) {
                Storage::disk('public')->makeDirectory('image_profile');
            }
            if (Storage::disk('public')->exists('image_profile/' . $profile_img->image)) {
                Storage::disk('public')->delete('image_profile/' . $profile_img->image);
            }
            $profile_image = Image::make($image)->resize(300, 300)->stream();
            Storage::disk('public')->put('image_profile/' . $imagename, $profile_image);
            $profile_img->image = $imagename;
            $profile_img->save();
        }
        \Session::flash('flash_message', 'Successfully Added');
        return redirect('attendant');
    }

    public function show($id){
        abort_if(Gate::denies('ManageAttendant'), redirect('error'));
        $data = Attendant::findOrFail($id);
        return view('attendant.show',compact('data'));
    }

    public function edit(Attendant $attendant){
        abort_if(Gate::denies('ManageAttendant'), redirect('error'));
        return view('attendant.edit',compact('attendant'));
    }

    public function update(Request $request,Attendant $attendant){
        $this->validate($request, [
            'name' => 'required|unique:attendants,name,' . $attendant->id,
            'contact_no' => [
                'required',
                'regex:/^\+\d{13}$/',
                'unique:attendants,contact_no,' . $attendant->id,
            ],
            'image' => 'mimes:png,jpeg,jpg,bmp | max:1024'
        ]);
        $attendant->update($request->all());
        // Image update
        $image = $request->file('image');

        if(isset($image)){
            $slug = 'ip';
            $profile_img = Attendant::find($attendant->id);
            $utime = round(microtime(true) * 1000);
            $imagename = $slug . '-' . $utime . '.' . $image->getClientOriginalExtension();
            if (!Storage::disk('public')->exists('image_profile')) {
                Storage::disk('public')->makeDirectory('image_profile');
            }
            if (Storage::disk('public')->exists('image_profile/' . $profile_img->image) && $profile_img->image != 'default_image.png') {
                Storage::disk('public')->delete('image_profile/' . $profile_img->image);
            }
            $profile_image = Image::make($image)->resize(300, 300)->stream();
            Storage::disk('public')->put('image_profile/' . $imagename, $profile_image);
            $profile_img->image = $imagename;
            $profile_img->save();
        }
        \Session::flash('flash_message', 'Successfully updated');
        return redirect('attendant');
    }

    public function destroy($id){
        abort_if(Gate::denies('ManageAttendant'), redirect('error'));
        $data = Attendant::findOrFail($id);
        $data->delete();
        \Session::flash('flash_message', 'Successfully deleted');
        return redirect('attendant');
    }
}
