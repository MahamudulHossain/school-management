@extends('layouts.al4_main')
@section('exam_mo','menu-open')
@section('exam','active')
@section('manage_exam_report','active')
@section('title','Exam Report')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Exam Report</a>
    </li>
@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('alte4/plugins/select2/css/select2.min.css') }}">
@endpush
@section('maincontent')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#clsRpt" data-toggle="tab">Class wise report </a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#stuRpt" data-toggle="tab">Student wise report </a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="clsRpt">
                                <div class="row">
                                    {{-- Term wise  --}}
                                    <form action="{{ route("exam-report-class-term") }}" method="get" id="saveForm">
                                    @csrf
                                    <div class="form-group row mb-3{{ $errors->has('school_class_id') ? ' has-error' : '' }}">
                                        <label class="col-md-5 control-label"> Select Class : <span class="required"> * </span></label>
                                        <div class=" col-md-5">
                                            <select name="school_class_id" id="clsRpt_school_class_id" class="form-control select2" required>
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
                                        <label class="col-md-5 control-label"> Select section : <span class="required"> * </span></label>
                                        <div class=" col-md-5">
                                            <select name="school_section_id" id="clsRpt_school_section_id" class="form-control select2" required>
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
                                    <div class="form-group row mb-3{{ $errors->has('exam_type_id') ? ' has-error' : '' }}">
                                        <label class="col-md-5 control-label"> Select Exam Type : <span class="required"> * </span></label>
                                        <div class=" col-md-5">
                                            <select name="exam_type_id" id="clsRpt_exam_type_id" class="form-control select2" required>
                                                <option value="" disabled selected>Select Exam Type</option>
                                                @foreach($exam_types as $id=>$title)
                                                    <option value="{{ $id }}">{{ $title }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('exam_type_id'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('exam_type_id') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3{{ $errors->has('academic_year_id') ? ' has-error' : '' }}">
                                        <label class="col-md-5 control-label"> Select Academic Year : <span class="required"> * </span></label>
                                        <div class=" col-md-5">
                                            <select name="academic_year_id" id="clsRpt_academic_year_id" class="form-control select2" required>
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

                                    <div class="col-md-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-success" id="saveButton"><i
                                                    class="fa fa-save"
                                                    aria-hidden="true"></i> Search
                                        </button>
                                    </div>
                                    </form>
                                </div>

                                <div class="row">
                                    {{-- Subject wise  --}}
                                    <form action="{{ route("exam-report-class-subject") }}" method="get" id="saveForm2">
                                    @csrf
                                    <div class="form-group row mb-3{{ $errors->has('school_class_id') ? ' has-error' : '' }}">
                                        <label class="col-md-5 control-label"> Select Class : <span class="required"> * </span></label>
                                        <div class=" col-md-5">
                                            <select name="school_class_id" id="school_class_id_clsRpt" class="form-control select2" required>
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
                                        <label class="col-md-5 control-label"> Select section : <span class="required"> * </span></label>
                                        <div class=" col-md-5">
                                            <select name="school_section_id" id="school_section_id_clsRpt" class="form-control select2" required>
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
                                    <div class="form-group row mb-3{{ $errors->has('subject_id') ? ' has-error' : '' }}">
                                        <label class="col-md-5 control-label"> Select Subject : <span class="required"> * </span></label>
                                        <div class=" col-md-5">
                                            <select name="subject_id" id="subject_id_clsRpt" class="form-control select2" required>
                                                <option value="" disabled selected>Select Subject</option>
                                                @foreach($subjects as $id=>$title)
                                                    <option value="{{ $id }}">{{ $title }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('subject_id'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('subject_id') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3{{ $errors->has('academic_year_id') ? ' has-error' : '' }}">
                                        <label class="col-md-5 control-label"> Select Academic Year : <span class="required"> * </span></label>
                                        <div class=" col-md-5">
                                            <select name="academic_year_id" id="academic_year_id_clsRpt" class="form-control select2" required>
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

                                    <div class="col-md-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-success" id="saveButton"><i
                                                    class="fa fa-save"
                                                    aria-hidden="true"></i> Search
                                        </button>
                                    </div>
                                    </form>
                                </div>
                            </div>

                            <div class="tab-pane" id="stuRpt">
                                <div class="row">
                                    {{-- Student wise  --}}
                                    <form action="{{ route("exam-report-class-student") }}" method="get" id="saveForm3">
                                    @csrf
                                    <div class="form-group row mb-3{{ $errors->has('school_class') ? ' has-error' : '' }}">
                                        <label class="col-md-5 control-label"> Select Class : <span class="required"> * </span></label>
                                        <div class=" col-md-5">
                                            <select name="school_class" id="_stuRpt_school_class" class="form-control select2" required style="width: 100%">
                                                <option value="" disabled selected>Select Class</option>
                                                @foreach($school_classes as $id=>$class_name)
                                                    <option value="{{ $id }}">{{ $class_name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('school_class'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('school_class') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3{{ $errors->has('school_section') ? ' has-error' : '' }}">
                                        <label class="col-md-5 control-label"> Select section : <span class="required"> * </span></label>
                                        <div class=" col-md-5">
                                            <select name="school_section" id="_stuRpt_school_section" class="form-control select2" required style="width: 100%">
                                                <option value="" disabled selected>Select Section</option>
                                                @foreach($school_sections as $id=>$section_name)
                                                    <option value="{{ $id }}">{{ $section_name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('school_section'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('school_section') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3{{ $errors->has('academic_year') ? ' has-error' : '' }}">
                                        <label class="col-md-5 control-label"> Select Academic Year : <span class="required"> * </span></label>
                                        <div class=" col-md-5">
                                            <select name="academic_year" id="_stuRpt_academic_year" class="form-control select2" required style="width: 100%">
                                                <option value="" disabled selected>Select Academic Year</option>
                                                @foreach($academic_years as $id=>$title)
                                                    <option value="{{ $id }}" {{ getSessionAcademicYear() ==  $id ? 'selected':''}}>{{ $title }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('academic_year'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('academic_year') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3{{ $errors->has('roll') ? ' has-error' : '' }}">
                                        <label class="col-md-5 control-label"> Student Roll : <span class="required"> * </span></label>
                                        <div class=" col-md-5">
                                            <input type="number" class="form-control" name="roll" placeholder="Enter roll number" autocomplete="off" required>
                                            @if ($errors->has('roll'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('roll') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-success" id="saveButton"><i
                                                    class="fa fa-save"
                                                    aria-hidden="true"></i> Search
                                        </button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
<script src="{!! asset('alte4/plugins/select2/js/select2.full.min.js')!!}"></script>

<script>
    $(document).ready(function () {
        $('.select2').select2();
    });
</script>

{{--prevent multiple form submits (Jquery needed)--}}
<script>
    $('form').submit(function () {
        $(this).find('button[type=submit]')
            .html("Please Wait...")
            .attr('disabled', 'disabled');
    });
</script>
@endpush
