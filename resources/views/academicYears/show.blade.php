@extends('layouts.al4_main')
@section('academic_mo','menu-open')
@section('academic','active')
@section('academic_year_mo','menu-open')
@section('academic_year','active')
@section('manage_academic_year','active')
@section('title','Academic Year')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('academicYear')}}" class="nav-link">Academic Year</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Show Academic Year</a>
    </li>
@endsection
@push('css')
@endpush
@section('maincontent')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Show Academic Year</h3>
        </div>

        <div class="card-body">
            <div class="mb-2">
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            Academic Year
                        </th>
                        <td>
                            {{ $academicYear->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Description
                        </th>
                        <td>
                            {{ $academicYear->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Start Date
                        </th>
                        <td>
                            {{ \Carbon\Carbon::parse($academicYear->start_date)->format('Y-m-d') }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            End Date
                        </th>
                        <td>
                            {{ \Carbon\Carbon::parse($academicYear->end_date)->format('Y-m-d') }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer">
            <a href="{{ url()->previous() }}" class="btn btn-outline-primary btn-sm"><i
                        class="fa fa-arrow-left"
                        aria-hidden="true"></i>{{ __('all_settings.Back') }}</a>
            {{--                    @can('geo_location-access')--}}
            <form method="POST" action="{{ url('academicYear/' . $academicYear->id) }}" style="display:inline">
                @csrf
                @method('DELETE')

                <button type="submit"
                    class="btn btn-danger btn-sm"
                    title="Delete"
                    onclick="return confirm('Confirm delete?')">
                    <span class="far fa-trash-alt" aria-hidden="true" title="Delete"></span>
                </button>
            </form>
            <a href="{{ url('academicYear/' . $academicYear->id . '/edit') }}"
               class="btn btn-info btn-sm fa-pull-right" title="Edit" style="margin-right: 10px"><span
                        class="far fa-edit"
                        aria-hidden="true"></span></a>

        </div>
    </div>

@endsection
