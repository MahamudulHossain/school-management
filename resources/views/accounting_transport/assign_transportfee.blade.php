@extends('layouts.al4_main')
@section('transport_mo','menu-open')
@section('transport','active')
@section('manage_transport_fees','active')
@section('title','Assign Transport Fee')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Assign Transport Fee</a>
    </li>
@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('alte4/plugins/select2/css/select2.min.css') }}">
@endpush
@section('maincontent')
<meta name="_token" content="{{ csrf_token() }}"/>
    <div class="row justify-content-center ">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Assign Transport Fee</h3>
                </div>
                <form action="{{ url("accounting-transport/create") }}" method="get" id="saveForm">
                    @csrf
                    <div class="card-body">

                        <div class="form-group row mb-3{{ $errors->has('academic_year_id') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label"> Select Academic Year : <span class="required"> * </span></label>
                            <div class=" col-md-6">
                                <select name="academic_year_id" id="academic_year_id" class="form-control select2" required>
                                    <option value="" disabled selected>Select Academic Year</option>
                                    @foreach($academic_years as $id=>$title)
                                        <option value="{{ $id }}">{{ $title }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('academic_year_id'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('academic_year_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3{{ $errors->has('month') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label"> Select Month: <span class="required"> * </span></label>
                            <div class=" col-md-6">
                                <select name="month" id="month" class="form-control" required>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ $i == date('n') ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                                        </option>
                                    @endfor
                                </select>
                                @if ($errors->has('month'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('month') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3{{ $errors->has('month') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label"> Due Date:<span class="required"> * </span></label>
                            <div class="col-md-6">
                                <input type="date" name="due_date" class="form-control" required>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <button type="submit" class="btn btn-success float-right" id="saveButton"><i
                                    class="fa fa-save"
                                    aria-hidden="true"></i> Next
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
<script type="text/javascript">
    $("select[name='school_class_id']").change(function(){
        var school_class_id = $(this).val();
        var token = $("input[name='_token']").val();
        $.ajax({
            url: "<?php echo route('selectajax_exam') ?>",
            method: 'POST',
            data: {school_class_id:school_class_id, _token:token},
            success: function(data) {
                // console.log(data);
                $("select[name='exam_type_id']").html('');
                $("select[name='exam_type_id']").html(data);
            }
        });
    });
</script>
@endpush
