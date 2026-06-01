@extends('layouts.al4_main')
@section('academic_mo','menu-open')
@section('academic','active')
@section('academic_year_mo','menu-open')
@section('academic_year','active')
@section('manage_academic_year','active')
@section('title','Academic Year Update')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('academicYear')}}" class="nav-link">Academic Year</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Update Academic Year</a>
    </li>
@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('alte4/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('alte4/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
<link rel="stylesheet"
      href="{{ asset('alte4/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endpush
@section('maincontent')

    <div class="row justify-content-center ">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Update Academic Year</h3>
                </div>
                <form action="{{ route('academicYear.update', $academicYear->id) }}" method="POST" id="saveForm">
                    @method('PATCH')
                    @csrf
                    <div class="card-body">
                        <div class="form-group row mb-3{{ $errors->has('title') ? 'has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label text-md-right">
                                Academic Year :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" id="title" name="title" class="form-control"
                                    value="{{ old('title', isset($academicYear) ? $academicYear->title : '') }}" required>
                                @if($errors->has('title'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('title') }}
                                    </em>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3  {{ $errors->has('description') ? 'has-error' : '' }}">
                            <label for="description" class="col-md-4 control-label text-md-right">
                                Description :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" id="description" name="description" class="form-control" autofocus
                                        value="{{ old('description', isset($academicYear) ? $academicYear->description : '') }}" required>
                                @if($errors->has('description'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('description') }}
                                    </em>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-8 mb-3">
                            <div class="form-group row align-items-center {{ $errors->has('start_date') ? ' has-error' : '' }}">

                                <label class="col-md-6 control-label text-md-left">
                                    Start Date : <span class="required">*</span>
                                </label>

                                <div class="col-md-6"> <div class="input-group date" id="start_date" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" name="start_date"
                                                value="{{ \Carbon\Carbon::parse($academicYear->start_date)->format('Y-m-d') }}" data-target="#start_date"/>
                                        <div class="input-group-append" data-target="#start_date"
                                                data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-7"> @if ($errors->has('start_date'))
                                        <span class="help-block text-danger"> <strong>{{ $errors->first('start_date') }}</strong>
                                        </span>
                                    @endif
                                </div>

                            </div>
                        </div>

                        <div class="col-md-8 mb-3">
                            <div class="form-group row align-items-center {{ $errors->has('end_date') ? ' has-error' : '' }}">

                                <label class="col-md-6 control-label text-md-left">
                                    End Date : <span class="required">*</span>
                                </label>

                                <div class="col-md-6"> <div class="input-group date" id="end_date" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" name="end_date"
                                                value="{{ \Carbon\Carbon::parse($academicYear->end_date)->format('Y-m-d') }}" data-target="#end_date"/>
                                        <div class="input-group-append" data-target="#end_date"
                                                data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-7"> @if ($errors->has('end_date'))
                                        <span class="help-block text-danger"> <strong>{{ $errors->first('end_date') }}</strong>
                                        </span>
                                    @endif
                                </div>

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
<script src="{!! asset('alte4/plugins/select2/js/select2.full.min.js')!!}"></script>
<script src="{!! asset('alte4/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')!!}"></script>
<script src="{!! asset('alte4/plugins/jquery-ui/jquery-ui.min.js')!!}"></script>

<script src="{!! asset('alte4/plugins/moment/moment.min.js')!!}"></script>
<script src="{!! asset('alte4/plugins/inputmask/min/jquery.inputmask.bundle.min.js')!!}"></script>
<script src="{!! asset('alte4/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')!!}"></script>

<script>
    $(function () {
        $('#datemask').inputmask('dd-mm-yyyy', {'placeholder': 'dd-mm-yyyy'})

        //Date range picker
        $('#start_date').datetimepicker({
            date: moment(),
            format: 'DD-MM-Y'
        });

        $('#end_date').datetimepicker({
            date: moment(),
            format: 'DD-MM-Y'
        });
    })
</script>
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        $('.duallistbox').bootstrapDualListbox()


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
