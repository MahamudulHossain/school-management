@extends('layouts.al4_main')
@section('academic_mo','menu-open')
@section('academic','active')
@section('subject_mo','menu-open')
@section('subject','active')
@section('manage_subject','active')
@section('title','Subject Update')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('subject')}}" class="nav-link">Subject</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Update Subject</a>
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
                    <h3 class="card-title">Update Subject</h3>
                </div>
                <form action="{{ route('subject.update', $subject->id) }}" method="POST" id="saveForm">
                    @method('PATCH')
                    @csrf
                    <div class="card-body">
                        <div class="form-group row mb-3{{ $errors->has('subject_name') ? 'has-error' : '' }}">
                            <label for="subject_name" class="col-md-4 control-label text-md-right">
                                Subject Name :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" id="subject_name" name="subject_name" class="form-control"
                                    value="{{ old('subject_name', isset($subject) ? $subject->subject_name : '') }}" required>
                                @if($errors->has('subject_name'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('subject_name') }}
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
