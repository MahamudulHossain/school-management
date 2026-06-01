@extends('layouts.al4_main')
@section('accounting_mo','menu-open')
@section('accounting','active')
@section('manage_sFee','active')
@section('title','Manage Fee')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('sFee')}}" class="nav-link">Manage Fee</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Update Fee</a>
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
                    <h3 class="card-title">Update Fee</h3>
                </div>
                <form action="{{ route('sFee.update', $accounting_sfee->id) }}" method="POST" id="saveForm">
                    @method('PATCH')
                    @csrf
                    <div class="card-body">
                        <div class="form-group row mb-3{{ $errors->has('school_class_id') ? ' has-error' : '' }}">
                            <label class="control-label col-md-4 text-right">Select Class:
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <select name="school_class_id" class="form-control" id="school_class_id" required>
                                    <option value="" disabled selected>Select Class</option>
                                    @foreach($school_classes as $id => $school_class)
                                        <option value="{{$id}}" {{ old('school_class_id', $accounting_sfee->school_class_id) == $id ? 'selected' : '' }}>{{$school_class}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('school_class_id'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('school_class_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3{{ $errors->has('fee_name') ? ' has-error' : '' }}">
                            <label class="control-label col-md-4 text-right">Fee Title:
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" name="fee_name" class="form-control" value="{{ $accounting_sfee->fee_name }}" required>
                                @if ($errors->has('fee_name'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('fee_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label class="control-label col-md-4 text-right">Description:
                            </label>
                            <div class="col-md-6">
                                <input type="text" name="description" class="form-control" value="{{ $accounting_sfee->description }}">
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3{{ $errors->has('amount') ? ' has-error' : '' }}">
                            <label class="control-label col-md-4 text-right">Amount:
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <input type="number" name="amount" class="form-control" step="0.1" value="{{ $accounting_sfee->amount }}" required>
                                @if ($errors->has('amount'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('amount') }}</strong>
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
