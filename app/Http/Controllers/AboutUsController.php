<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        abort_if(Gate::denies('FrontendSettings'), redirect('error'));
        $data = AboutUs::first();
        return view('frontsettings.about_us.index', compact('data'));
    }


    public function edit(string $id)
    {
        abort_if(Gate::denies('FrontendSettings'), redirect('error'));
        $data = AboutUs::findOrFail($id);
        return view('frontsettings.about_us.edit', compact('data'));
    }


    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('FrontendSettings'), redirect('error'));
        $aboutUs = AboutUs::findOrFail($id);

        $this->validate($request, [
            'image' => 'mimes:png,jpeg,jpg,bmp | max:1024 | dimensions:width=689,height=458',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($aboutUs->image) {
                Storage::disk('public')->delete('front/aboutus/' . $aboutUs->image);
            }

            $utime = round(microtime(true) * 1000);
            $image = $request->file('image');
            $slug = 'aboutus';
            $imagename = $slug . '-' . $utime . '.' . $image->getClientOriginalExtension();
            $aboutus_image = Image::make($image)->resize(689, 458)->stream();
            Storage::disk('public')->put('front/aboutus/' . $imagename, $aboutus_image);
            $aboutUs->image = $imagename;
        }

        $aboutUs->description = $request->description;
        $aboutUs->mission = $request->mission;
        $aboutUs->vision = $request->vision;
        $aboutUs->goal = $request->goal;
        $aboutUs->save();

        \Session::flash('flash_success', 'About Us Updated Successfully');
        return redirect('about-us');
    }
}
