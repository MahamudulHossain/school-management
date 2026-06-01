@extends('layouts.al4_main')
@section('dashboard_mo','menu-open')
@section('dashboard','active')
@section('title','Dashboard')
@push('css')
@endpush
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Dashboard</a>
    </li>
@endsection

@section('maincontent')

    <div class="row mt-3">
        <h2>STUDENT DASHBOARD</h2>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box text-bg-warning">
                <span class="info-box-icon"> <i class="bi bi-calendar3"></i> </span>
                <div class="info-box-content">
                <span class="info-box-text">Attendance</span>
                <span class="info-box-number">{{ $currentMonthAttendance['present'] }}</span>
                <span class="progress-description"> In {{ $currentMonthAttendance['total_days'] }} Days </span>
                </div>
            </div>
        </div>

    </div>

    @include('partials.notice_calendar')

@endsection
@push('js')
@endpush
