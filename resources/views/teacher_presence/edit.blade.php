@extends('layouts.al4_main')
@section('teacher_mo','menu-open')
@section('teacher','active')
@section('manage_attendance','active')
@section('title','Update Attendance')
@push('css')
<link rel="stylesheet" href="{{ asset('supporting/dataTables/bs4/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('supporting/dataTables/fixedHeader.dataTables.min.css') }}">
{{--<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.dataTables.min.css">--}}
@endpush
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Update Attendance</a>
    </li>
@endsection

@section('maincontent')
    <div class="card card-success card-tabs">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                       href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                       aria-selected="true">Update Attendance</a>
                </li>

            </ul>
        </div>
        <form action="{{ route('teacher_presence.update', $date) }}" class="form-horizontal" method="POST">
            @method('PATCH')
            @csrf
            <div class="card-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr style="background-color: #dff0d8">
                            <th>S.No</th>
                            <th>Teacher Name</th>
                            <th>Date</th>
                            <th>In Time</th>
                            <th>Out Time</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    @foreach ($date_presence as $key => $dp)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>
                                {{$dp->user->teacher->first_name.' '.$dp->user->teacher->middle_name.' '.$dp->user->teacher->last_name}}
                                ({{ $dp->user->personnel_id }})
                                <input type="hidden" name="user_id[]" value="{{ $dp->user_id }}">
                            </td>
                            <td>{{ Carbon\Carbon::parse($dp->date)->format('d-M-Y') ?? '' }}</td>
                            <td>
                                <div class="input-group">
                                    <input type="time" name="in_time[]" class="form-control" value="{{ $dp->in_time }}">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">
                                            <i class="fa fa-clock-o"></i>
                                        </button>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="time" name="out_time[]" class="form-control" value="{{ $dp->out_time }}">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">
                                            <i class="fa fa-clock-o"></i>
                                        </button>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <input type="text" name="remarks[]" value="{{ $dp->remarks }}" class="form-control" placeholder="Remarks">
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <button type="submit" class="btn btn-success" id="saveButton">
                    <i class="fa fa-save" aria-hidden="true"></i> Save
                </button>
            </div>
        </form>
    </div>
@endsection
@push('js')

@endpush
