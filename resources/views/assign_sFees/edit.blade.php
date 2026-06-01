@extends('layouts.al4_main')
@section('accounting_mo','menu-open')
@section('accounting','active')
@section('manage_assign_sFee','active')
@section('title','Manage Assign fee')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Manage Assign fee</a>
    </li>
@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('alte4/plugins/jquery-ui/jquery-ui.min.css') }}">
<link rel="stylesheet" href="{{ asset('alte4/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('alte4/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('alte4/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush
@section('maincontent')
<meta name="_token" content="{{ csrf_token() }}"/>
    <div class="row justify-content-center ">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Manage Assign fee</h3>
                </div>
                <form action="{{ route("update.assign-fees") }}" method="POST" id="saveForm">
                    @csrf
                    <div class="card-body">

                        <div class="form-group row mb-3 {{ $errors->has('stu_name') ? 'has-error' : '' }}">
                            <label for="stu_name" class="col-md-4 control-label text-md-right">
                                Student Name :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" id="stu_name" name="stu_name" value="{{ $data->user->student->first_name.' '.$data->user->student->middle_name.' '.$data->user->student->last_name }}" class="form-control" disabled>
                                <input type="hidden" name="id" value="{{ $data->id }}">
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('fee_title') ? 'has-error' : '' }}">
                            <label for="fee_title" class="col-md-4 control-label text-md-right">
                                Fee Title :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" id="fee_title" name="fee_title" value="{{ $data->accounting_sfee->fee_name }}" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('due_date') ? 'has-error' : '' }}">
                            <label for="due_date" class="col-md-4 control-label text-md-right">
                                Due Date :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" id="due_date" name="due_date" value="{!! Carbon\Carbon::parse($data->due_date )->format('d-M-Y') !!}" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('fee_amount') ? 'has-error' : '' }}">
                            <label for="fee_amount" class="col-md-4 control-label text-md-right">
                                Fee Amount :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="number" id="fee_amount" name="fee_amount" value="{{ $data->fee_amount }}" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('collect_amount') ? 'has-error' : '' }}">
                            <label for="collect_amount" class="col-md-4 control-label text-md-right">
                                Paid Amount :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="number" id="collect_amount" name="collect_amount" value="{{ $data->collect_amount ?? '' }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('fine_amount') ? 'has-error' : '' }}">
                            <label for="fine_amount" class="col-md-4 control-label text-md-right">
                                Fine Amount :
                            </label>
                            <div class="col-md-6">
                                <input type="number" id="fine_amount" name="fine_amount" value="{{ $data->fine_amount ?? '' }}" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('discount_amount') ? 'has-error' : '' }}">
                            <label for="discount_amount" class="col-md-4 control-label text-md-right">
                                Discount Amount :
                            </label>
                            <div class="col-md-6">
                                <input type="number" id="discount_amount" name="discount_amount" value="{{ $data->discount_amount ?? '' }}" class="form-control">
                            </div>
                        </div>


                        <div class="form-group row mb-3 {{ $errors->has('collect_date') ? ' has-error' : '' }}">
                            <label class="col-md-4 col-form-label text-md-left">
                                Collection Date : <span class="required">*</span>
                            </label>

                            <div class="col-md-6">
                                <div class="input-group date" id="collect_date" data-target-input="nearest">
                                    <input
                                        type="text"
                                        class="form-control datetimepicker-input"
                                        name="collect_date"
                                        value="{{ $data->collect_date ? Carbon\Carbon::parse(date('Y-m-d ', strtotime($data->collect_date)))->format('dd-mm-YYYY') : \Carbon\Carbon::now()->format('d-m-Y') }}"
                                        data-target="#collect_date"
                                        required
                                    />
                                    <div class="input-group-append" data-target="#collect_date" data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>

                                @if ($errors->has('collect_date'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('collect_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('is_status') ? 'has-error' : '' }}">
                            <label for="is_status" class="col-md-4 control-label text-md-right">
                                Payment Status :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <select name="is_status" id="is_status" class="form-control">
                                    <option value="0" {{ $data->is_status == 0 ? 'selected' : '' }}>Unpaid</option>
                                    <option value="1" {{ $data->is_status == 1 ? 'selected' : '' }}>Paid</option>
                                </select>
                            </div>
                        </div>


                    </div>

                    <div class="card-footer">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('all_settings.Back') }}
                        </a>
                        <button type="submit" class="btn btn-success" id="saveButton">
                            <i class="fa fa-save" aria-hidden="true"></i> Save
                        </button>
                    </div>


                </form>

            </div>
        </div>
    </div>

@endsection
@push('js')
<script src="{!! asset('alte4/plugins/jquery-ui/jquery-ui.min.js')!!}"></script>
<script src="{!! asset('alte4/plugins/moment/moment.min.js')!!}"></script>
<script src="{!! asset('alte4/plugins/inputmask/min/jquery.inputmask.bundle.min.js')!!}"></script>
<script src="{!! asset('alte4/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')!!}"></script>

<script>
    $(function () {
        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd-mm-yyyy', {'placeholder': 'dd-mm-yyyy'})
        //Date range picker
        $('#collect_date').datetimepicker({
            format: 'DD-MM-YYYY'
        });
    })

</script>
@endpush
