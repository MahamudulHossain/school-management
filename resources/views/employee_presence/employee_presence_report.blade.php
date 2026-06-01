@extends('layouts.al4_main')
@section('employee_mo','menu-open')
@section('employee','active')
@section('employee_presence_report','active')
@section('title','Employee Attendance Report')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Employee Attendance Report</a>
    </li>
@endsection
@push('css')
<link rel="stylesheet" href="{!! asset('alte4/plugins/daterangepicker/daterangepicker.css')!!}">
@endpush
@section('maincontent')
    <div class="row justify-content-center ">
        <div class="col-md-12">
            <div class="card card-success card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                               href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                               aria-selected="true">Date range wise report</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill"
                               href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile"
                               aria-selected="false">Employee wise report</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">

                        <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel"
                             aria-labelledby="custom-tabs-one-home-tab">
                            <div>
                                <div>
                                    <div class="caption">
                                        <i class="fa fa-gift"></i> Date range wise Attendance Report
                                    </div>
                                </div>

                                <form action="{{ url('employee_attendance_reportbyrange') }}" method="POST" class="form-horizontal">
                                    @csrf
                                    <div class="form-group text-center">
                                        <div class="d-inline-flex align-items-center gap-2">
                                            <div class="input-group" style="display: inline-block;">
                                                <button type="button" class="btn btn-default" id="daterange-btn">
                                                    <i class="far fa-calendar-alt"></i> Select Date Ranges:
                                                    <i class="fas fa-caret-down"></i>
                                                </button>
                                                @if($errors->has('date_range'))
                                                    <em class="invalid-feedback">
                                                        {{ $errors->first('date_range') }}
                                                    </em>
                                                @endif
                                            </div>
                                            <button type="submit" class="btn btn-circle btn-success">Show</button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="date_range" id="date_range">

                                </form>

                            </div>
                        </div>


                        <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                                aria-labelledby="custom-tabs-one-profile-tab">
                            <div>
                                <div>
                                    <div class="caption">
                                        <i class="fa fa-gift"></i> Employee wise Attendance Report
                                    </div>
                                </div>

                                <form action="{{ url('attendance_report_byemployee') }}" method="POST" class="form-horizontal">
                                    @csrf
                                    <div class="form-group text-center">
                                        <div class="d-inline-flex gap-2">
                                            <div class="input-group" style="display: inline-block;">
                                                <button type="button" class="btn btn-default" id="daterange-btn2">
                                                    <i class="far fa-calendar-alt"></i> Select Date Ranges:
                                                    <i class="fas fa-caret-down"></i>
                                                </button>
                                                @if($errors->has('date_range'))
                                                    <em class="invalid-feedback">
                                                        {{ $errors->first('date_range') }}
                                                    </em>
                                                @endif
                                            </div>
                                            <div style="width: 100%">
                                                <select name="user_id" id="user_id" class="form-control" required>
                                                    <option value="">Select employee</option>
                                                    @foreach ($employees as $t)
                                                        <option value="{{ $t->id }}">
                                                            {{ $t->employee->first_name.' '.$t->employee->middle_name.' '.$t->employee->last_name}}
                                                            ({{ $t->personnel_id }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <button type="submit" class="btn btn-circle btn-sm btn-success">Show</button>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="date_range" id="date_range2">

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

<script src="{!! asset('alte4/plugins/moment/moment.min.js')!!}" type="text/javascript"></script>
<script src="{!! asset('alte4/plugins/daterangepicker/daterangepicker.js')!!}" type="text/javascript"></script>
<script>
$(function () {
    // Initialize date range picker for first tab
    $('#daterange-btn').daterangepicker(
        {
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [
                    moment().subtract(1, 'month').startOf('month'),
                    moment().subtract(1, 'month').endOf('month')
                ]
            },
            startDate: moment().subtract(29, 'days'),
            endDate: moment(),
            locale: {
                format: 'YYYY-MM-DD'
            }
        },
        function (start, end) {
            // Update button text for first tab
            updateButtonText('#daterange-btn', start, end);

            // Store in hidden input for first tab
            $('#date_range').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        }
    );

    // Initialize date range picker for second tab
    $('#daterange-btn2').daterangepicker(
        {
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [
                    moment().subtract(1, 'month').startOf('month'),
                    moment().subtract(1, 'month').endOf('month')
                ]
            },
            startDate: moment().subtract(29, 'days'),
            endDate: moment(),
            locale: {
                format: 'YYYY-MM-DD'
            }
        },
        function (start, end) {
            // Update button text for second tab
            updateButtonText('#daterange-btn2', start, end);

            // Store in hidden input for second tab
            $('#date_range2').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        }
    );

    // Function to update button text
    function updateButtonText(buttonSelector, start, end) {
        // Remove existing date span if any
        $(buttonSelector).find('.date-range-text').remove();

        // Add new date span
        $(buttonSelector).append(
            '<span class="date-range-text"> ' + start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD') + '</span>'
        );
    }

    // Set initial button text for both buttons
    var initialStart = moment().subtract(29, 'days');
    var initialEnd = moment();

    updateButtonText('#daterange-btn', initialStart, initialEnd);
    updateButtonText('#daterange-btn2', initialStart, initialEnd);

    // Set initial values for hidden inputs
    $('#date_range').val(initialStart.format('YYYY-MM-DD') + ' - ' + initialEnd.format('YYYY-MM-DD'));
    $('#date_range2').val(initialStart.format('YYYY-MM-DD') + ' - ' + initialEnd.format('YYYY-MM-DD'));
});
</script>
@endpush

