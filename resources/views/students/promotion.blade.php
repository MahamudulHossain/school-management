@extends('layouts.al4_main')
@section('student_mo','menu-open')
@section('student','active')
@section('promotion','active')
@section('title','Student Promotion')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Student Promotion</a>
    </li>
@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('alte4/plugins/select2/css/select2.min.css') }}">
@endpush
@section('maincontent')
    <div class="row justify-content-center ">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Student Promotion</h3>
                </div>
                <form action="{{ route("promotion-store") }}" method="post" id="saveForm">
                    <input type="hidden" name="school_class_id_pre" value="{{ $school_class_id }}">
                    <input type="hidden" name="school_section_id_pre" value="{{ $school_section_id }}">
                    <input type="hidden" name="academic_year_id_pre" value="{{ $academic_year_id }}">
                    @csrf
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr style="text-align: center">
                                <th width="15%">ID</th>
                                <th width="15%">Student Name</th>
                                <th width="5%">Current Roll</th>
                                <th width="10%">Total Marks</th>
                                <th width="45%">Promoted To</th>
                                <th width="10%">New Roll</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($promotion as $stu)
                                <tr>
                                    <td>{{ $stu->personnel_id }}</td>
                                    <td>{{ $stu->first_name }} {{ $stu->middle_name }} {{ $stu->last_name }}
                                    <input type="hidden" name="user_id[]" value="{{ $stu->user_id }}">
                                    </td>
                                    <td>{{$stu->roll}}</td>
                                    <td>{{$stu->total_marks}}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <select name="school_class_id[]" id="school_class_id" class="form-control">
                                                @foreach ($school_classes as $sckey=>$school_class)
                                                    <option value="{{ $sckey }}">{{ $school_class }}</option>
                                                @endforeach
                                            </select>
                                            <select name="school_section_id[]" id="school_section_id" class="form-control">
                                                @foreach ($school_sections as $seckey=>$school_section)
                                                    <option value="{{ $seckey }}">{{ $school_section }}</option>
                                                @endforeach
                                            </select>
                                            <select name="academic_year_id[]" id="academic_year_id" class="form-control">
                                                @foreach ($academic_years as $ackey=>$academic_year)
                                                    <option value="{{ $ackey }}">{{ $academic_year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td><input type="number" name="roll[]" class="form-control" min="1" required></td>
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
