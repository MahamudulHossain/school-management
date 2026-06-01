@extends('layouts.al4_main')
@section('exam_mo','menu-open')
@section('exam','active')
@section('manage_marks_check','active')
@section('title','Exam Marks Check')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Exam Marks Check</a>
    </li>
@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('alte4/plugins/select2/css/select2.min.css') }}">
@endpush
@section('maincontent')
    <div class="row justify-content-center ">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Exam Marks Check</h3>
                </div>
                <form action="{{ route("exam-marks-check-view") }}" method="get" id="saveForm">
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
                                        <option value="{{ $id }}" {{ getSessionAcademicYear() ==  $id ? 'selected':''}}>{{ $title }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('academic_year_id'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('academic_year_id') }}</strong>
                                </span>
                                @endif
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
