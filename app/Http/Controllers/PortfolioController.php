<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\PortfolioTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PortfolioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        abort_if(Gate::denies('FrontendSettings'), redirect('error'));
        $portfolios = Portfolio::with('tag')->get();
        return view('frontsettings.portfolio.index', compact('portfolios'));
    }

    public function create()
    {
        abort_if(Gate::denies('addPortfolio'), redirect('error'));
        $tags = PortfolioTag::where('status', 'active')->get();
        return view('frontsettings.portfolio.create', compact('tags'));
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('addPortfolio'), redirect('error'));
        $request->validate([
            'portfolio_tag_id' => 'required|exists:portfolio_tags,id',
            'image' => 'mimes:png,jpeg,jpg,bmp | required | max:1024 | dimensions:width=800,height=600',
        ]);

        $utime = round(microtime(true) * 1000);
        $image = $request->file('image');
        $slug = 'prt';
        $imagename = $slug . '-' . $utime . '.' . $image->getClientOriginalExtension();
        $prt_image = Image::make($image)->resize(1982, 954)->stream();
        Storage::disk('public')->put('front/portfolio/' . $imagename, $prt_image);

        $portfolio = new Portfolio();
        $portfolio->portfolio_tag_id = $request->portfolio_tag_id;
        $portfolio->image = $imagename;
        $portfolio->save();

        \Session::flash('flash_success', 'Portfolio Created Successfully');
        return redirect('portfolio');
    }


    public function edit(Portfolio $portfolio)
    {
        abort_if(Gate::denies('editPortfolio'), redirect('error'));
        $tags = PortfolioTag::where('status', 'active')->get();
        return view('frontsettings.portfolio.edit', compact('portfolio', 'tags'));
    }


    public function update(Request $request, Portfolio $portfolio)
    {
        abort_if(Gate::denies('editPortfolio'), redirect('error'));
        $request->validate([
            'portfolio_tag_id' => 'required|exists:portfolio_tags,id',
            'image' => 'mimes:png,jpeg,jpg,bmp | max:1024 | dimensions:width=800,height=600',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($portfolio->image && Storage::disk('public')->exists('front/portfolio/' . $portfolio->image)) {
                Storage::disk('public')->delete('front/portfolio/' . $portfolio->image);
            }

            $utime = round(microtime(true) * 1000);
            $image = $request->file('image');
            $slug = 'prt';
            $imagename = $slug . '-' . $utime . '.' . $image->getClientOriginalExtension();
            $prt_image = Image::make($image)->resize(1982, 954)->stream();
            Storage::disk('public')->put('front/portfolio/' . $imagename, $prt_image);

            $portfolio->image = $imagename;
        }

        $portfolio->portfolio_tag_id = $request->portfolio_tag_id;
        $portfolio->save();

        \Session::flash('flash_success', 'Portfolio Updated Successfully');
        return redirect('portfolio');
    }


    public function destroy(Portfolio $portfolio)
    {
        abort_if(Gate::denies('deletePortfolio'), redirect('error'));
        // Delete image
        if ($portfolio->image && Storage::disk('public')->exists('front/portfolio/' . $portfolio->image)) {
            Storage::disk('public')->delete('front/portfolio/' . $portfolio->image);
        }

        $portfolio->delete();

        \Session::flash('flash_success', 'Portfolio Deleted Successfully');
        return redirect('portfolio');
    }
}
