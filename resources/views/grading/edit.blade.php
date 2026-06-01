@extends('layouts.al4_main')
@section('exam_mo','menu-open')
@section('exam','active')
@section('grading','active')
@section('title','Grading Update')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('grading')}}" class="nav-link">Manage Grading</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Update Grading</a>
    </li>
@endsection
@push('css')
@endpush
@section('maincontent')

    <div class="row justify-content-center ">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Update Grading</h3>
                </div>
                <form action="{{ route('grading.update', $grading->id) }}" method="POST" id="saveForm">
                    @method('PATCH')
                    @csrf
                    <div class="card-body">

                        <div class="form-group row mb-3 {{ $errors->has('starting_marks') ? 'has-error' : '' }}">
                            <label for="starting_marks" class="col-md-4 control-label text-md-right">
                                Starting Marks :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="number" id="starting_marks" name="starting_marks" class="form-control" autofocus
                                    value="{{ old('starting_marks', isset($grading) ? $grading->starting_marks : '') }}" required>
                                @if($errors->has('starting_marks'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('starting_marks') }}
                                    </em>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('ending_marks') ? 'has-error' : '' }}">
                            <label for="ending_marks" class="col-md-4 control-label text-md-right">
                                Ending Marks :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="number" id="ending_marks" name="ending_marks" class="form-control"
                                    value="{{ old('ending_marks', isset($grading) ? $grading->ending_marks : '') }}" required>
                                @if($errors->has('ending_marks'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('ending_marks') }}
                                    </em>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('letter_grade') ? 'has-error' : '' }}">
                            <label for="letter_grade" class="col-md-4 control-label text-md-right">
                                Letter Grade :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" id="letter_grade" name="letter_grade" class="form-control"
                                    value="{{ old('letter_grade', isset($grading) ? $grading->letter_grade : '') }}" required>
                                @if($errors->has('letter_grade'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('letter_grade') }}
                                    </em>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('grade_point') ? 'has-error' : '' }}">
                            <label for="grade_point" class="col-md-4 control-label text-md-right">
                                Grade Point :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="number" id="grade_point" name="grade_point" class="form-control" step="0.01"
                                    value="{{ old('grade_point', isset($grading) ? $grading->grade_point : '') }}" required>
                                @if($errors->has('grade_point'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('grade_point') }}
                                    </em>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('remarks') ? 'has-error' : '' }}">
                            <label for="remarks" class="col-md-4 control-label text-md-right">
                                Remarks :
                            </label>
                            <div class="col-md-6">
                                <textarea id="remarks" name="remarks" class="form-control">{{ old('remarks', isset($grading) ? $grading->remarks : '') }}</textarea>
                                @if($errors->has('remarks'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('remarks') }}
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
