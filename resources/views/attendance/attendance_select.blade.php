@extends('layouts.al4_main')
@section('student_mo','menu-open')
@section('student','active')
@section('student_attendance','active')
@section('title','Student Attendance')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Student Attendance</a>
    </li>
@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('alte4/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet"
      href="{{ asset('alte4/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endpush
@section('maincontent')
    <div class="row justify-content-center ">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Student Attendance</h3>
                </div>
                <form action="{{ route("attendance.create") }}" method="get" id="saveForm">
                    @csrf
                    <div class="card-body">

                        <div class="form-group row mb-3{{ $errors->has('school_class_id') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label"> Select Class : <span class="required"> * </span></label>
                            <div class=" col-md-6">
                                <select name="school_class_id" id="school_class_id" class="form-control select2" required>
                                    <option value="" disabled selected>Select Class</option>
                                    @foreach($school_classes as $id=>$class_name)
                                        <option value="{{ $id }}">{{ $class_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('school_class_id'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('school_class_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3{{ $errors->has('school_section_id') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label"> Select section : <span class="required"> * </span></label>
                            <div class=" col-md-6">
                                <select name="school_section_id" id="school_section_id" class="form-control select2" required>
                                    <option value="" disabled selected>Select Section</option>
                                    @foreach($school_sections as $id=>$section_name)
                                        <option value="{{ $id }}">{{ $section_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('school_section_id'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('school_section_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3{{ $errors->has('academic_year_id') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label"> Select Academic Year : <span class="required"> * </span></label>
                            <div class=" col-md-6">
                                <select name="academic_year_id" id="academic_year_id" class="form-control select2" required>
                                    <option value="" disabled selected>Select Academic Year</option>
                                    @foreach($academic_years as $id=>$title)
                                        <option value="{{ $id }}" {{ $sessionAcademicYear ==  $id ? 'selected':''}}>{{ $title }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('academic_year_id'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('academic_year_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3{{ $errors->has('date') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Date:<span class="required"> * </span></label>
                            <div class="col-md-6">
                                <div class="input-group date" id="date" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" name="date"
                                            value="{{ old('date') }}" data-target="#date"/>
                                    <div class="input-group-append" data-target="#date"
                                            data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                <div class="col-md-7"> @if ($errors->has('date'))
                                        <span class="help-block text-danger"> <strong>{{ $errors->first('date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <button type="submit" class="btn btn-success float-right" id="saveButton"><i
                                    class="fa fa-save"
                                    aria-hidden="true"></i> Next
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection
@push('js')
<script src="{!! asset('alte4/plugins/select2/js/select2.full.min.js')!!}"></script>
<script src="{!! asset('alte4/plugins/jquery-ui/jquery-ui.min.js')!!}"></script>
<script src="{!! asset('alte4/plugins/moment/moment.min.js')!!}"></script>
<script src="{!! asset('alte4/plugins/inputmask/min/jquery.inputmask.bundle.min.js')!!}"></script>
<script src="{!! asset('alte4/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')!!}"></script>

<script>
    $(function () {
        $('#datemask').inputmask('dd-mm-yyyy', {'placeholder': 'dd-mm-yyyy'})

        //Date range picker
        $('#date').datetimepicker({
            date: moment(),
            format: 'DD-MM-Y'
        });
    })
</script>
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
