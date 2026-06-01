@extends('layouts.al4_main')
@section('settings_mo','menu-open')
@section('settings','active')
@section('manage_subject_class_mapping','active')
@section('title','Edit Subject Class Mapping')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('subject-class-mapping')}}" class="nav-link">Subject Class Mapping</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Edit Subject Class Mapping</a>
    </li>
@endsection
@push('css')

<!-- Tempusdominus Bbootstrap 4 -->
<link rel="stylesheet"
      href="{{ asset('alte4/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('alte4/plugins/select2/css/select2.min.css') }}">

@endpush
@section('maincontent')
    <div class="row justify-content-center ">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Subject Class Mapping</h3>
                </div>
                <form id="saveForm" method="POST" action="{{ url('subject-class-mapping/'.$school_class_id) }}" class="form-horizontal">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="card-body">

                    <div class="form-group row mb-3{{ $errors->has('school_class_id') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4 text-right">Select Class:
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-6">
                            <select name="school_class_id" class="form-control select2" id="school_class_id" required>
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{$class->id}}" {{ $class->id == $school_class_id ? 'selected' : '' }}>{{$class->class_name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('school_class_id'))
                                <span class="help-block">
                                <strong>{{ $errors->first('school_class_id') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-3{{ $errors->has('subject_id') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4 text-right">Select Subjects:
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-6">
                            <select name="subject_id[]" class="form-control select2" id="subject_id" required multiple="multiple">
                                <option value="">Select Subject</option>
                                @foreach($subjects as $id => $subject)
                                    <option value="{{$subject->id}}" {{ in_array($subject->id, $mappedSubjects) ? 'selected' : '' }}>{{$subject->subject_name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('subject_id'))
                                <span class="help-block">
                                <strong>{{ $errors->first('subject_id') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-primary"><i
                                class="fa fa-arrow-left"
                                aria-hidden="true"></i>{{ __('all_settings.Back') }}</a>
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
<!-- InputMask for Date picker-->
<script src="{!! asset('alte4/plugins/moment/moment.min.js')!!}"></script>
<script src="{!! asset('alte4/plugins/inputmask/min/jquery.inputmask.bundle.min.js')!!}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{!! asset('alte4/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')!!}"></script>
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
