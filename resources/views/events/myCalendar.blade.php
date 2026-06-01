@extends('layouts.al4_main')
@section('event_mo','menu-open')
@section('event','active')
@section('view_event','active')
@section('title','Events & Holidays')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">View Events</a>
    </li>
@endsection
@section('maincontent')
<div class="row justify-content-center ">
    <div>
        <h3>Event Calendar</h3>
        <hr/>
    </div>
    <div id="calendar"></div>
</div>

@endsection
@push('js')
    <!-- FullCalendar from CDN -->
    <script src="{{ asset('alte4/dist/js/full_calendar.min.js') }}"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: siteURL + '/events' // this hits the Laravel route
        });
        calendar.render();
    });
    </script>
@endpush
