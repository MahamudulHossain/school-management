@extends('layouts.al4_main')
@section('leave_mo','menu-open')
@section('leave','active')
@section('list_leavetype','active')
@section('title','Leave Type Update')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('leave-type')}}" class="nav-link">Leave Types</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Update Leave Type</a>
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
                    <h3 class="card-title">Update Leave Type</h3>
                </div>
                <form action="{{ route('leave-type.update', $leave_type->id) }}" method="POST" id="saveForm">
                    @method('PATCH')
                    @csrf
                    <div class="card-body">
                        <div class="form-group row mb-3{{ $errors->has('leave_type_name') ? 'has-error' : '' }}">
                            <label for="leave_type_name" class="col-md-4 control-label text-md-right">
                                Leave Type Name :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" id="leave_type_name" name="leave_type_name" class="form-control"
                                    value="{{ old('leave_type_name', isset($leave_type) ? $leave_type->leave_type_name : '') }}" required>
                                @if($errors->has('leave_type_name'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('leave_type_name') }}
                                    </em>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3{{ $errors->has('comments') ? 'has-error' : '' }}">
                            <label for="comments" class="col-md-4 control-label text-md-right">
                                Comments :
                            </label>
                            <div class="col-md-6">
                                <input type="text" id="comments" name="comments" class="form-control"
                                    value="{{ old('comments', isset($leave_type) ? $leave_type->comments : '') }}" required>
                                @if($errors->has('comments'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('comments') }}
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
