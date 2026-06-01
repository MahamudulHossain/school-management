@extends('layouts.al4_main')
@section('student_mo','menu-open')
@section('student','active')
@section('student_attendance_edit','active')
@section('title','Modify Student Attendance')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Modify Student Attendance</a>
    </li>
@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('alte4/plugins/select2/css/select2.min.css') }}">
@endpush
@section('maincontent')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Modify Student Attendance</h3>
                </div>

                <form action="{{ route("student-attendance.updateByClass") }}" method="POST" id="saveForm">
                    @csrf
                    <input type="hidden" name="school_class_id" value="{{$k_id}}">
                    <input type="hidden" name="school_section_id" value="{{$s_id}}">
                    <input type="hidden" name="academic_year_id" value="{{$academic_year_id}}">
                    <input type="hidden" name="date" value="{{$date}}">
                    <div class="card-body">
                        <div class="form-body" style="margin-bottom: 5px">
                            <span class="text-muted"><b>Class :</b></span>{{$schoolClass->class_name}}<span class="text-muted">,</span>
                            <span class="text-muted"><b>Section:</b></span>{{$schoolSection->section_name}}<br>
                            <span class="text-muted"><b>Date:</b></span>{{Carbon\Carbon::parse($date)->format('d-M-Y')}}</span><span class="text-muted">,</span>
                            <span class="text-muted"><b>Academic year:</b></span>{{$academicYear->title}}
                        </div>
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr >
                                    <th>ID</th><th> Student Name </th><th> Roll No </th><th >Attendance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendance as $stu)
                                    <tr>
                                        <td>{{ $stu->student->user->personnel_id }}</td>
                                        <td>{{ $stu->student->first_name }} {{ $stu->student->last_name }}
                                            <input type="hidden" name="student_id[]" value="{{ $stu->student->id }}">
                                        </td>
                                        <td>{{$stu->roll}}
                                            <input type="hidden" name="roll[]" value="{{ $stu->roll }}">
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <select name="attendance[]" id="attendance" class="form-control">
                                                    <option value="Present" {{ $stu->attendance == "Present" ? 'selected' : '' }}>Present</option>
                                                    <option value="Absent" {{ $stu->attendance == "Absent" ? 'selected' : '' }}>Absent</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <button type="submit" class="btn btn-success float-right" id="saveButton"><i
                                    class="fa fa-save"
                                    aria-hidden="true"></i> Save
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection
@push('js')
<script src="{!! asset('alte4/plugins/select2/js/select2.full.min.js')!!}"></script>

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
    })
</script>

{{--prevent multiple form submits (Jquery needed)--}}
<script>
    $('#saveForm').submit(function () {
        $("#saveButton", this)
            .html("Please Wait...")
            .attr('disabled', 'disabled');
        return true;
    });
</script>
@endpush
