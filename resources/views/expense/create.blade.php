@extends('layouts.al4_main')
@section('accounting_mo','menu-open')
@section('accounting','active')
@section('manage_expense','active')
@section('title','Add Expense')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Add Expense</a>
    </li>
@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('alte4/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('alte4/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
<link rel="stylesheet" href="{{ asset('alte4/plugins/jquery-ui/jquery-ui.min.css') }}">
<link rel="stylesheet" href="{{ asset('alte4/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('alte4/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('alte4/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush
@section('maincontent')

    <div class="row justify-content-center ">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add Expense</h3>
                </div>
                <form action="{{ route("expense.store") }}" method="POST" id="saveForm">
                    @csrf
                    <div class="card-body">

                        <div class="form-group row mb-3 {{ $errors->has('expense_type_id') ? 'has-error' : '' }}">
                            <label for="expense_type_id" class="col-md-4 control-label text-md-right">
                                Select Expense Type:<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <select name="expense_type_id" id="expense_type_id" class="form-control" required>
                                    <option value="" selected disabled>Select Expense Type</option>
                                    @foreach ($expenseTypes as $expenseType)
                                        <option value="{{ $expenseType->id }}">{{ $expenseType->expense_name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('expense_type_id'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('expense_type_id') }}
                                    </em>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('expense_date') ? ' has-error' : '' }}">
                            <label class="col-md-4 col-form-label text-md-left">
                                Expense Date : <span class="required">*</span>
                            </label>

                            <div class="col-md-6">
                                <div class="input-group date" id="expense_date" data-target-input="nearest">
                                    <input
                                        type="text"
                                        class="form-control datetimepicker-input"
                                        name="expense_date"
                                        value="{{ old('expense_date') }}"
                                        data-target="#expense_date"
                                        required
                                    />
                                    <div class="input-group-append" data-target="#expense_date" data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>

                                @if ($errors->has('expense_date'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('expense_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('expense_amount') ? 'has-error' : '' }}">
                            <label for="expense_amount" class="col-md-4 control-label text-md-right">
                                Expense Amount:<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="expense_amount" required>
                                @if($errors->has('expense_amount'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('expense_amount') }}
                                    </em>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('comments') ? 'has-error' : '' }}">
                            <label for="comments" class="col-md-4 control-label text-md-right">
                                Comments:
                            </label>
                            <div class="col-md-6">
                                <textarea name="comments" id="comments" cols="20" rows="5" class="form-control"></textarea>
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
<script src="{!! asset('alte4/plugins/jquery-ui/jquery-ui.min.js')!!}"></script>
<script src="{!! asset('alte4/plugins/moment/moment.min.js')!!}"></script>
<script src="{!! asset('alte4/plugins/inputmask/min/jquery.inputmask.bundle.min.js')!!}"></script>
<script src="{!! asset('alte4/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')!!}"></script>

<script>
    $(function () {
        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd-mm-yyyy', {'placeholder': 'dd-mm-yyyy'})
        //Date range picker
        $('#expense_date').datetimepicker({
            date: moment(),
            format: 'DD-MM-Y'
        });
    })

</script>
<script>
    $('#saveForm').submit(function () {
        $("#saveButton", this)
            .html("Please Wait...")
            .attr('disabled', 'disabled');
        return true;
    });
</script>
@endpush
