@extends('layouts.al4_main')
@section('accounting_mo','menu-open')
@section('accounting','active')
@section('manage_expense_type','active')
@section('title','Add Expense Type')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Add Expense Type</a>
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
                    <h3 class="card-title">Add Expense Type</h3>
                </div>
                <form action="{{ route("expense-type.store") }}" method="POST" id="saveForm">
                    @csrf
                    <div class="card-body">

                        <div class="form-group row mb-3 {{ $errors->has('expense_name') ? 'has-error' : '' }}">
                            <label for="expense_name" class="col-md-4 control-label text-md-right">
                                Expense Type Name :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" id="expense_name" name="expense_name" class="form-control" autofocus
                                    value="{{ old('expense_name') }}" required>
                                @if($errors->has('expense_name'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('expense_name') }}
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
