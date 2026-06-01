<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\PortfolioTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PortfolioTagController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        abort_if(Gate::denies('PortfolioTagManagement'), redirect('error'));
        $data = PortfolioTag::all();
        return view('frontsettings.portfolio_tag.index', compact('data'));
    }

    public function create()
    {
        abort_if(Gate::denies('PortfolioTagManagement'), redirect('error'));
        return view('frontsettings.portfolio_tag.create');
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('PortfolioTagManagement'), redirect('error'));
        $request->validate([
            'title' => 'required|unique:portfolio_tags|max:255',
        ]);
        $data = new PortfolioTag();
        $data->title = $request->title;
        $data->tag = Str::slug($request->title, '-');
        $data->status = $request->status;
        $data->save();

        \Session::flash('flash_success', 'Portfolio Tag Created Successfully');
        return redirect('portfolio-tag');
    }

    public function edit($id)
    {
        abort_if(Gate::denies('PortfolioTagManagement'), redirect('error'));
        $data = PortfolioTag::find($id);
        return view('frontsettings.portfolio_tag.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('PortfolioTagManagement'), redirect('error'));
        $request->validate([
            'title' => 'required|max:255|unique:portfolio_tags,title,' . $id,
        ]);
        $data = PortfolioTag::find($id);
        $data->title = $request->title;
        $data->tag = Str::slug($request->title, '-');
        $data->status = $request->status;
        $data->save();

        \Session::flash('flash_success', 'Portfolio Tag Updated Successfully');
        return redirect('portfolio-tag');
    }


}
