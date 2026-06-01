<?php

namespace App\Http\Controllers;

use App\Models\Transport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\TransportCreateRequest;
use App\Http\Requests\TransportUpdateRequest;

class TransportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        abort_if(Gate::denies('TransportInfo'), redirect('error'));
        $transports = Transport::orderBy('created_at', 'desc')->get();
        return view('transport.index', compact('transports'));
    }

    public function create(){
        abort_if(Gate::denies('TransportInfo'), redirect('error'));
        return view('transport.create');
    }

    public function store(TransportCreateRequest $request){
        Transport::create($request->validated());
        \Session::flash('flash_message', 'Successfully Added');
        return redirect('transport');
    }

    public function edit(Transport $transport){
        abort_if(Gate::denies('TransportInfo'), redirect('error'));
        return view('transport.edit',compact('transport'));
    }

    public function update(TransportUpdateRequest $request, Transport $transport){
        $transport->update($request->validated());
        \Session::flash('flash_message', 'Successfully Updated');
        return redirect('transport');
    }

    public function destroy($id){
        $data = Transport::findOrFail($id);
        $data->delete();
        \Session::flash('flash_message', 'Successfully Deleted');
        return redirect('transport');
    }
}
