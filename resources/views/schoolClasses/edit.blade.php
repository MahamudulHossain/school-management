@extends('layouts.al4_main')
@section('academic_mo','menu-open')
@section('academic','active')
@section('class_mo','menu-open')
@section('class','active')
@section('manage_class','active')
@section('title','Class')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('schoolClass')}}" class="nav-link">Class</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Update Class</a>
    </li>
@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('alte4/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('alte4/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
@endpush
@section('maincontent')

    <div class="row justify-content-center ">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Update Class</h3>
                </div>
                <form action="{{ route('schoolClass.update', $schoolClass->id) }}" method="POST" id="saveForm">
                    @method('PATCH')
                    @csrf
                    <div class="card-body">
                        <div class="form-group row mb-3{{ $errors->has('class_name') ? 'has-error' : '' }}">
                            <label for="class_name" class="col-md-4 control-label text-md-right">
                                Class Name :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" id="class_name" name="class_name" class="form-control"
                                    value="{{ old('class_name', isset($schoolClass) ? $schoolClass->class_name : '') }}" required>
                                @if($errors->has('class_name'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('class_name') }}
                                    </em>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('number_of_periods') ? 'has-error' : '' }}">
                            <label for="number_of_periods" class="col-md-4 control-label text-md-right">
                                Number of Periods :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="number" id="number_of_periods" name="number_of_periods" class="form-control" autofocus
                                        value="{{ old('number_of_periods', isset($schoolClass) ? $schoolClass->number_of_periods : '') }}" required>
                                @if($errors->has('number_of_periods'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('number_of_periods') }}
                                    </em>
                            @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3{{ $errors->has('numeric_no') ? 'has-error' : '' }}">
                            <label for="numeric_no" class="col-md-4 control-label text-md-right">
                                Class Numeric :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="number" id="numeric_no" name="numeric_no" class="form-control" autofocus
                                        value="{{ old('numeric_no', isset($schoolClass) ? $schoolClass->numeric_no : '') }}" required>
                                @if($errors->has('numeric_no'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('numeric_no') }}
                                    </em>
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
<script src="{!! asset('alte4/plugins/select2/js/select2.full.min.js')!!}"></script>
<script src="{!! asset('alte4/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')!!}"></script>

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
