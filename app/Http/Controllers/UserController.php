<?php

namespace App\Http\Controllers;

use DB;
use DateTime;
use App\Models\Role;
use App\Models\User;
use App\Models\Profile;
use App\Models\Setting;
use App\Models\UserType;
use Illuminate\Support\Arr;
use App\Models\ImageProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
            $users = User::get();
        elseif (Auth::user()->user_type_id == 1 && Auth::user()->email != 'superadmin@eidyict.com')
            $users = User::where('id', '>', '1')->get();
        else
            $users = User::where('user_type_id', '!=', 1)->get();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('UserAccess'), redirect('error'));
        $user_types = UserType::where('status', 'Active')->get();
        return view('user.create', compact('user_types'));
    }

    public function store(UserCreateRequest $request)
    {
        abort_if(Gate::denies('UserAccess'), redirect('error'));

        try {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->cell_phone = $request->cell_phone;
            $user->password = bcrypt($request->password);
            $user->user_type_id = $request->user_type;
            $user->web_access = $request->web_access;
            $user->save();

            $profile = new Profile();
            $profile->user_id = $user->id;
            $profile->gender = $request->gender;
            $profile->save();

            $image_profile = new ImageProfile();
            $image_profile->user_id = $user->id;
            $image_profile->save();

            $role_ids = $request->user_type;
            $user->roles()->attach($role_ids);

            \Session::flash('flash_message', 'Successfully Added');

        } catch (\Exception $e) {
            \Session::flash('flash_error', 'Failed to save , Try again.');
        }

        return redirect('user');
    }


    public function show(User $user)
    {
        abort_if(Gate::denies('UserAccess'), redirect('error'));

        if ($user->id == 1 && Auth::user()->id != 1) {
            \Session::flash('flash-error', 'You cannot view Admin ');
            return \Redirect::to('user');
        }

        if ($user->user_type_id == 1)
            $user_type = 'Admin';
        else
            $user_type = 'User';

        $title_date_range=$user->name;
        return view('user.show_sc', compact('user','user_type','title_date_range'));
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('UserAccess'), redirect('error'));
        if ($user->id < 2 && Auth::user()->id != 1) {
            \Session::flash('flash-error', 'You cannot edit System admin ');
            return \Redirect::to('user');
        }

        $user = User::find($user->id);
        if (Auth::user()->email == 'superadmin@eidyict.com')
            $roles = Role::pluck('title', 'id');
        else
            $roles = Role::where('title', '!=', 'Super Admin')->pluck('title', 'id');
        $user_types = UserType::get();

        return view('user.edit', compact('user', 'roles', 'user_types'));
    }

    public function update(User $user, UserUpdateRequest $request)
    {
        abort_if(Gate::denies('UserAccess'), redirect('error'));
        if ($user->id == 1 && Auth::user()->id != 1) {
            \Session::flash('flash_error', 'You cannot edit Super Admin ');
            return \Redirect::to('user');
        } else {

            $input = $request->all();

            if (!empty($input['password'])) {
                $input['password'] = bcrypt($input['password']);
            } else {
                unset($input['password']);
            }

//            dd($input);
            $user = User::find($user->id);
//            dd($user);
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

            if ($user_type == 1)
                return redirect('user');
        }
    }

    public function myprofile()
    {
        $user = \Auth::user();

        if ($user->user_type_id == 1)
            $user_type = 'Admin';
        else
            $user_type = 'User';
//        dd($ledger1);
        $title_date_range='Show User';
        return view('user.show_sc', compact('user','user_type','title_date_range'));
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


}
