@extends('layouts.al4_main')
@section('superadmin_mo','menu-open')
@section('superadmin','active')
@section('manage_exam_criteria','active')
@section('title','Add Exam Criteria')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('exam-criteria')}}" class="nav-link">Manage Exam Criteria</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Add Exam Criteria</a>
    </li>
@endsection
@push('css')
@endpush
@section('maincontent')

    <div class="row justify-content-center ">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add Exam Criteria</h3>
                </div>
                <form action="{{ route("exam-criteria.store") }}" method="POST" id="saveForm">
                    @csrf
                    <div class="card-body">

                        <div class="form-group row mb-3 {{ $errors->has('criteria_name') ? 'has-error' : '' }}">
                            <label for="criteria_name" class="col-md-4 control-label text-md-right">
                                Exam Criteria title :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" id="criteria_name" name="criteria_name" class="form-control" autofocus
                                    value="{{ old('criteria_name')}}" required>
                                @if($errors->has('criteria_name'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('criteria_name') }}
                                    </em>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-md-4 control-label text-right">Status:<span
                                        class="required"> * </span></label>
                            <div class="col-md-6 mt-radio-inline">
                                <label class="mt-radio">
                                    <input type="radio" name="status"
                                        value="active" checked>Active
                                    <span></span>
                                </label>
                                <label class="mt-radio">
                                    <input type="radio" name="status"
                                        value="inactive">Inactive
                                    <span></span>
                                </label>
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
