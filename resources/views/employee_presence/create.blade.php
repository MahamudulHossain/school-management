@extends('layouts.al4_main')
@section('employee_mo','menu-open')
@section('employee','active')
@section('employee_presence','active')
@section('title','Add Attendance')
@push('css')
<link rel="stylesheet" href="{{ asset('supporting/dataTables/bs4/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('supporting/dataTables/fixedHeader.dataTables.min.css') }}">
<link rel="stylesheet"
      href="{{ asset('alte4/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endpush
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Add Attendance</a>
    </li>
@endsection

@section('maincontent')
    <div class="card card-success card-tabs">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                       href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                       aria-selected="true">Add Attendance</a>
                </li>

            </ul>
        </div>
        <form action="{{ url('employee_presence') }}" class="form-horizontal" method="POST">
            @csrf
            <div class="card-body">
                <div class="col-md-12 mb-3">
                    <div class="form-group row align-items-center {{ $errors->has('date') ? ' has-error' : '' }}">

                        <label class="col-md-2 control-label text-md-left">
                            Attendance Date : <span class="required">*</span>
                        </label>

                        <div class="col-md-3"> <div class="input-group date" id="date" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" name="date"
                                        value="{{ old('date') }}" data-target="#date"/>
                                <div class="input-group-append" data-target="#date"
                                        data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7"> @if ($errors->has('date'))
                                <span class="help-block text-danger"> <strong>{{ $errors->first('date') }}</strong>
                                </span>
                            @endif
                        </div>

                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr style="background-color: #dff0d8">
                            <th>S.No</th>
                            <th>Employee Name</th>
                            <th>Email</th>
                            <th>Personnel ID</th>
                            <th>In Time</th>
                            <th>Out Time</th>
                            <th>Remarks </th>
                        </tr>
                    </thead>
                    @foreach ($employees as $key => $employee)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>
                                {{$employee->employee->first_name.' '.$employee->employee->middle_name.' '.$employee->employee->last_name}}
                                <input type="hidden" name="user_id[]" value="{{ $employee->id }}">
                            </td>
                            <td>{{ $employee->email}}</td>
                            <td>{{ $employee->personnel_id}}</td>
                            <td>
                                <div class="input-group">
                                    <input type="time" name="in_time[]" class="form-control">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">
                                            <i class="fa fa-clock-o"></i>
                                        </button>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="time" name="out_time[]" class="form-control">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">
                                            <i class="fa fa-clock-o"></i>
                                        </button>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <input type="text" name="remarks[]" class="form-control" placeholder="Remarks">
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <button type="submit" class="btn btn-success" id="saveButton">
                    <i class="fa fa-save" aria-hidden="true"></i> Save
                </button>
            </div>
        </form>
    </div>
@endsection
@push('js')
<script src="{!! asset('alte4/plugins/jquery-ui/jquery-ui.min.js')!!}"></script>
<script src="{!! asset('alte4/plugins/moment/moment.min.js')!!}"></script>
<script src="{!! asset('alte4/plugins/inputmask/min/jquery.inputmask.bundle.min.js')!!}"></script>
<script src="{!! asset('alte4/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')!!}"></script>

<script>
    $(function () {
        $('#datemask').inputmask('dd-mm-yyyy', {'placeholder': 'dd-mm-yyyy'})

        //Date range picker
        $('#date').datetimepicker({
            date: moment(),
            format: 'DD-MM-Y'
        });
    })
</script>
@endpush
