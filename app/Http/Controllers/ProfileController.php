<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    public function update(ProfileUpdateRequest $request, Profile $profile)
    {
        $profile_data = Profile::where('id',$profile->id)->first();
        $profile_data->gender = $request->gender;
        $profile_data->nid = $request->nid;
        $profile_data->contact_no1 = $request->contact_no1;
        $profile_data->contact_no2 = $request->contact_no2;
        $profile_data->address = $request->address;
        $profile_data->joining_date = date('Y-m-d 00:00:01', strtotime($request->joining_date));
        $profile_data->date_of_birth = ($request->date_of_birth!=null) ? date('Y-m-d', strtotime($request->date_of_birth)) : null;
        $profile_data->save ();
        \Session::flash('flash_message','Successfully Updated');
        return redirect('user/' . $profile->user->id);
    }

}
