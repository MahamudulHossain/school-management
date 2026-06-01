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
        <h2>Guardian DASHBOARD</h2>
        @foreach ($currentMonthAttendanceInfo as $key=>$info)
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box text-bg-{{ $colors[$key] }}">
                    <span class="info-box-icon"> <i class="bi bi-{{ $icons[$key] }}"></i></span>
                    <div class="info-box-content">
                    <span class="info-box-text">{{ $info['name'] }}</span>
                    <span class="info-box-number">Present {{ $info['present'] }}</span>
                    <span class="progress-description"> In {{ $info['total_days'] }} Days </span>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    @include('partials.notice_calendar')

@endsection
@push('js')
@endpush
