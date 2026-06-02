<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FrontCarousel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CarouselController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        abort_if(Gate::denies('FrontendSettings'), redirect('error'));
        $carousels = FrontCarousel::all();
        return view('frontsettings.carousel.index',compact('carousels'));
    }

    public function create(){
        abort_if(Gate::denies('addCarousel'), redirect('error'));
        return view('frontsettings.carousel.create');
    }

    public function store(Request $request){
        abort_if(Gate::denies('addCarousel'), redirect('error'));
        $this->validate($request, [
            'image' => 'mimes:png,jpeg,jpg,bmp | required | max:1024 | dimensions:width=1982,height=954',
            'serial' => 'required|min:1'
        ]);
        $utime = round(microtime(true) * 1000);
        $image = $request->file('image');
        $slug = 'cr';
        $imagename = $slug . '-' . $utime . '.' . $image->getClientOriginalExtension();
        $cr_image = Image::make($image)->resize(1982, 954)->stream();
        Storage::disk('public')->put('front/carousel/' . $imagename, $cr_image);

        $frontCarousel = new FrontCarousel();
        $frontCarousel->image = $imagename;
        $frontCarousel->serial = $request->serial;
        $frontCarousel->status = $request->status;
        $frontCarousel->save();
        \Session::flash('flash_success', 'Carousel Stored Successfully');
        return redirect('carousel');
    }

    public function edit($id)
    {
        abort_if(Gate::denies('editCarousel'), redirect('error'));
        $frontCarousel = FrontCarousel::findOrFail($id);
        return view('frontsettings.carousel.edit', compact('frontCarousel'));
    }

    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('editCarousel'), redirect('error'));
        $this->validate($request, [
            'image' => 'mimes:png,jpeg,jpg,bmp | max:1024 | dimensions:width=1982,height=954',
            'serial' => 'required|min:1'
        ]);
        $frontCarousel = FrontCarousel::findOrFail($id);
        $utime = round(microtime(true) * 1000);
        $image = $request->file('image');
        if (isset($image)) {
            // delete old image
            if (Storage::disk('public')->exists('front/carousel/' . $frontCarousel->image)) {
                Storage::disk('public')->delete('front/carousel/' . $frontCarousel->image);
            }
            $slug = 'cr';
            $imagename = $slug . '-' . $utime . '.' . $image->getClientOriginalExtension();
            $cr_image = Image::make($image)->resize(1982, 954)->stream();
            Storage::disk('public')->put('front/carousel/' . $imagename, $cr_image);
        } else {
            $imagename = $frontCarousel->image;
        }
        $frontCarousel->image = $imagename;
        $frontCarousel->serial = $request->serial;
        $frontCarousel->status = $request->status;
        $frontCarousel->save();
        \Session::flash('flash_success', 'Carousel Updated Successfully');
        return redirect('carousel');
    }

    public function destroy($id)
    {
        abort_if(Gate::denies('deleteCarousel'), redirect('error'));
        $frontCarousel = FrontCarousel::findOrFail($id);
        // delete old image
        if (Storage::disk('public')->exists('front/carousel/' . $frontCarousel->image)) {
            Storage::disk('public')->delete('front/carousel/' . $frontCarousel->image);
        }
        $frontCarousel->delete();
        return redirect('carousel');
    }

}
