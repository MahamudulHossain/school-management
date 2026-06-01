<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TermController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
       abort_if(Gate::denies('TermAccess'), redirect('error'));
        $terms = Term::all();
        return view('terms.index', compact('terms'));
    }

    public function create()
    {
        abort_if(Gate::denies('TermCreate'), redirect('error'));
        return view('terms.create');
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('TermCreate'), redirect('error'));
        $this->validate($request, [
            'title' => 'required|unique:terms,title'
        ]);
        $term = Term::create($request->all());
        \Session::flash('flash_message', 'Successfully Added');

        return redirect()->route('term.index');
    }

    public function edit(Term $term)
    {
        abort_if(Gate::denies('TermAccess'), redirect('error'));
        // Check if the term exists
        if (!$term) {
            return redirect()->route('term.index')->with('error', 'Term not found');
        }
        return view('terms.edit', compact('term'));
    }

    public function update(Request $request, Term $term)
    {
        abort_if(Gate::denies('TermAccess'), redirect('error'));
        $this->validate($request, [
            'title' => 'required|unique:terms,title,' . $term->id,
        ]);
        $term->update($request->all());
        \Session::flash('flash_message', 'Successfully Updated');

        return redirect()->route('term.index');
    }

    public function show(Term $term)
    {
       abort_if(Gate::denies('TermAccess'), redirect('error'));
        return view('terms.show', compact('term'));
    }

    public function destroy(Term $term)
    {
        abort_if(Gate::denies('TermAccess'), redirect('error'));
        $term->delete();
        \Session::flash('flash_message', 'Successfully Deleted');
        return redirect()->route('term.index');
    }

}
