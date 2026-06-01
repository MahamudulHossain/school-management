<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Http\Requests\NoticeRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class NoticeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        abort_if(Gate::denies('ManageNotice'), redirect('error'));
        $sessionAcademicYear = sessionAcademicYearWithAll();
        $notices = Notice::select('id','title')->orderBy('created_at', 'desc');
        if(is_array($sessionAcademicYear)){
            $acdYr = AcademicYear::pluck('title')->toArray();
            $notices = $notices->whereIn(\DB::raw('YEAR(created_at)'), $acdYr)->get();
        }else{
            $acdYr = AcademicYear::find($sessionAcademicYear);
            $notices = $notices->whereYear('created_at',$acdYr->title)->get();
        }

        return view('notices.index', compact('notices'));
    }

    public function create()
    {
        abort_if(Gate::denies('CreateNotice'), redirect('error'));
        return view('notices.create');
    }

    public function store(NoticeRequest $request)
    {
        abort_if(Gate::denies('CreateNotice'), redirect('error'));
        $validated = $request->validated();

        // upload pdf
        $utime = round(microtime(true) * 1000);
        $pdf = $request->file('details');
        $slug = 'pdf';
        $pdfname = $slug . '-' . $utime . '.' . $pdf->getClientOriginalExtension();

        Storage::disk('public')->put('pdf/' . $pdfname, file_get_contents($pdf));

        Notice::create([
            'user_id' => Auth::user()->id,
            'title' => $validated['title'],
            'details' => $pdfname,
        ]);
        \Session::flash('flash_success', 'Notice Uploaded Successfully');
        return redirect('notice');
    }

    public function show($id)
    {
        abort_if(Gate::denies('ManageNotice'), redirect('error'));
        $notice = Notice::findOrFail($id);
        return view('notices.show', compact('notice'));
    }

    public function edit(Notice $notice)
    {
        abort_if(Gate::denies('EditNotice'), redirect('error'));
        return view('notices.edit',compact('notice' ));
    }

    public function update(Request $request, Notice $notice)
    {
        abort_if(Gate::denies('EditNotice'), redirect('error'));
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'details' => ['nullable', 'file', 'mimes:pdf', 'max:2048']
        ], [
            'title.required' => 'Please enter a title.',
            'details.mimes' => 'The file must be a PDF.',
            'details.max' => 'The PDF may not be greater than 2MB.',
        ]);

        // upload pdf
        if ($request->hasFile('details')) {
            // delete previous file
            Storage::disk('public')->delete('pdf/' . $notice->details);

            $utime = round(microtime(true) * 1000);
            $pdf = $request->file('details');
            $slug = 'pdf';
            $pdfname = $slug . '-' . $utime . '.' . $pdf->getClientOriginalExtension();

            Storage::disk('public')->put('pdf/' . $pdfname, file_get_contents($pdf));

            $notice->update([
                'title' => $validated['title'],
                'details' => $pdfname,
            ]);
        }
        else {
            $notice->update([
                'title' => $validated['title'],
            ]);
        }
        \Session::flash('flash_success', 'Notice Updated Successfully');
        return redirect('notice');
    }

    public function destroy(Notice $notice)
    {
        abort_if(Gate::denies('DeleteNotice'), redirect('error'));
        // delete previous file
        Storage::disk('public')->delete('pdf/' . $notice->details);

        $notice->delete();
        \Session::flash('flash_success', 'Notice Deleted Successfully');
        return redirect('notice');
    }
}
