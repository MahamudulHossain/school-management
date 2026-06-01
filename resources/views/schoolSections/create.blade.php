@extends('layouts.al4_main')
@section('academic_mo','menu-open')
@section('academic','active')
@section('section_mo','menu-open')
@section('section','active')
@section('add_section','active')
@section('title','Add Section')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('schoolSection')}}" class="nav-link">Section</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Add Section</a>
    </li>
@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('alte4/plugins/select2/css/select2.min.css') }}">
{{--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />--}}
{{--<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />--}}
<link rel="stylesheet" href="{{ asset('alte4/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
@endpush
@section('maincontent')

    <div class="row justify-content-center ">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add Section</h3>
                </div>
                <form action="{{ route("schoolSection.store") }}" method="POST" id="saveForm">
                    @csrf
                    <div class="card-body">

                        <div class="form-group row mb-3 {{ $errors->has('section_name') ? 'has-error' : '' }}">
                            <label for="section_name" class="col-md-4 control-label text-md-right">
                                Section Name :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" id="section_name" name="section_name" class="form-control" autofocus
                                    value="{{ old('section_name', isset($schoolSection) ? $schoolSection->section_name : '') }}" required>
                                @if($errors->has('section_name'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('section_name') }}
                                    </em>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3  {{ $errors->has('priority_no') ? 'has-error' : '' }}">
                            <label for="priority_no" class="col-md-4 control-label text-md-right">
                                Priority Index :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="number" id="priority_no" name="priority_no" class="form-control" autofocus
                                       value="{{ old('priority_no', isset($schoolSection) ? $schoolSection->priority_no : '') }}" required step="1" min="1">
                                @if($errors->has('priority_no'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('priority_no') }}
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
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>--}}
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
