@extends('layouts.al4_main')
@section('accounting_mo','menu-open')
@section('accounting','active')
@section('balance_report','active')
@section('title','Balance Report')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Balance Report</a>
    </li>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('supporting/bootstrap-daterangepicker/daterangepicker.min.css') }}">
@endpush
@section('maincontent')
    <div class="card card-success card-tabs">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                       href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                       aria-selected="true">Balance Report</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-one-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel"
                     aria-labelledby="custom-tabs-one-home-tab">
                    <div class="row justify-content-center">
                        <div class="card card-info col-md-8">
                            <div class="card-body">
                                <form action="{{ url('accounting-balance-report') }}" method="GET" class="form-horizontal">
                                <input type="hidden" id="StartDate" class="StartDate" name="start_date">
                                <input type="hidden" id="EndDate" class="EndDate" name="end_date">

                                <div class="form-group ">
                                    <label class="control-label col-md-4 text-md-right">{{ __('all_settings.Select Date Ranges') }} :</label>
                                    <div class="col-md-6 input-group " style="display: inline-block" >
                                        <button type="button" class="btn btn-default " id="reportrange" >
                                            <i class="far fa-calendar-alt"></i>
                                            <span> </span>
                                            <i class="fas fa-caret-down"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-default">{{ __('all_settings.Back') }}</button>
                                    <button type="submit" class="btn btn-info float-right"><i class="fa fa-search" aria-hidden="true"></i> {{ __('all_settings.Search') }}</button>
                                </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script src="{!! asset('alte4/plugins/moment/moment.min.js')!!}"></script>
<script src="{{ asset('supporting/bootstrap-daterangepicker/daterangepicker.min.js')}}"></script>
<script>
    $(document).ready(function () {
    var start = moment().subtract(30, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));
        $("#StartDate").val(start.format('YYYY-MM-DD'));
        $("#EndDate").val(end.format('YYYY-MM-DD'));
    }

    $('#reportrange').daterangepicker(
        {
            startDate: start,
            endDate: end,
            minDate: '01/01/2000',
            maxDate: '12/31/2050',
            showDropdowns: true,
            showWeekNumbers: true,
            timePicker: false,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 30 Days': [moment().subtract(30, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'Last 6 Months': [moment().subtract(6, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'This Year': [moment().startOf('year'), moment().endOf('year')],
                'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
                'The year before last year': [moment().subtract(2, 'year').startOf('year'), moment().subtract(2, 'year').endOf('year')]
            },
            opens: 'right',
            buttonClasses: ['btn btn-default'],
            applyClass: 'btn-small btn-primary',
            cancelClass: 'btn-small',
            locale: {
                applyLabel: 'Submit',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom Range',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            }
        },
        cb
    );
    cb(start, end);
});

</script>
@endpush

