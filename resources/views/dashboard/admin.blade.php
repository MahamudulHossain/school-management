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

    <div class="row">
        <h1>Admin Dashboard</h1>
    </div>
@endsection
@push('js')

@endpush
