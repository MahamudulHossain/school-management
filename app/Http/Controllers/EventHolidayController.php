<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\EventHoliday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;

class EventHolidayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function event_calendar()
    {
        return view('events.myCalendar');
    }
    public function getEvents()
    {
        $data = EventHoliday::all();
        $events = [];
        foreach ($data as $value) {
            $events[] = [
                'title' => $value->title,
                'start' => $value->start_date,
                'end'   => $value->end_date,
            ];
        }
        return response()->json($events);
    }
    public function index()
    {
        abort_if(Gate::denies('ManageEvents'), redirect('error'));
        $sessionAcademicYear = sessionAcademicYearWithAll();
        $events = EventHoliday::orderBy('start_date', 'desc');
        if(is_array($sessionAcademicYear)){
            $acdYr = AcademicYear::pluck('title')->toArray();
            $events = $events->whereIn(\DB::raw('YEAR(start_date)'), $acdYr)->get();
        }else{
            $acdYr = AcademicYear::find($sessionAcademicYear);
            $events = $events->whereYear('start_date',$acdYr->title)->get();
        }
        return view('events.index', compact('events'));
    }
    public function create()
    {
        abort_if(Gate::denies('ManageEvents'), redirect('error'));
        return view('events.create');
    }
    public function store(Request $request)
    {
        abort_if(Gate::denies('ManageEvents'), redirect('error'));
        $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'type' => 'required|string|in:holiday,non-holiday',
        ]);
        EventHoliday::create($request->all());
        return redirect()->route('event-holiday.index')->with('success', 'Event created successfully.');
    }
    public function show($id)
    {
        abort_if(Gate::denies('ManageEvents'), redirect('error'));
        $event = EventHoliday::findOrFail($id);
        return view('events.show', compact('event'));
    }
    public function edit($id)
    {
        abort_if(Gate::denies('ManageEvents'), redirect('error'));
        $event = EventHoliday::findOrFail($id);
        return view('events.edit', compact('event'));
    }
    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('ManageEvents'), redirect('error'));
        $event = EventHoliday::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'type' => 'required|string|in:holiday,non-holiday',
        ]);
        $event->update($request->all());
        return redirect()->route('event-holiday.index')->with('success', 'Event updated successfully.');
    }
    public function destroy($id)
    {
        abort_if(Gate::denies('ManageEvents'), redirect('error'));
        $event = EventHoliday::findOrFail($id);
        $event->delete();
        return redirect()->route('event-holiday.index')->with('success', 'Event deleted successfully.');
    }
}
