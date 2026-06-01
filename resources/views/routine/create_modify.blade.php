@extends('layouts.al4_main')
@section('timetable_mo','menu-open')
@section('timetable','active')
@section('class_timetable','active')
@section('title','Create/Modify Weekly Timetable')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Create/Modify Weekly Timetable</a>
    </li>
@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('alte4/plugins/select2/css/select2.min.css') }}">
@endpush
@section('maincontent')
    <div class="row justify-content-center ">
        <div class="col-md-12">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Create/Modify Weekly Timetable</h3>
                </div>
                <form action="{{ route("class-routine.store") }}" method="post" id="saveForm">
                    <input type="hidden" name="school_class_id" id="school_class_id" value="{{ $school_class_id }}">
                    <input type="hidden" name="school_section_id" id="school_section_id" value="{{ $school_section_id }}">
                    <input type="hidden" name="shift" id="shift" value="{{ $shift }}">
                    <input type="hidden" name="academic_year_id" id="academic_year_id" value="{{ $academic_year_id }}">
                    @csrf
                    <div class="card-body">
                        <table class="table table-bordered align-middle text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th>Day / Period</th>
                                    @foreach($periods as $period)
                                        <th>Period {{ $period }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($daysOfWeek as $day)
                                    <tr>
                                        <th class="bg-light">{{ $day }}</th>
                                        @foreach($periods as $period)
                                        @php
                                            $selectedSubject = $routineData[$day][$period]['subject_id'] ?? null;
                                            $selectedTeacher = $routineData[$day][$period]['teacher_id'] ?? null;
                                        @endphp
                                            <td>
                                                <div class="mb-2">
                                                    <select class="form-select subject-select" name="subject[{{ $day }}][{{ $period }}]">
                                                        <option value="">Select Subject</option>
                                                        @foreach($subjects as $subject)
                                                            <option value="{{ $subject->id }}" {{ $selectedSubject == $subject->id ? 'selected' : '' }}>{{ $subject->subject_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-1">
                                                    <select class="form-select teacher-select"
                                                            name="teacher[{{ $day }}][{{ $period }}]"
                                                            data-day="{{ $day }}"
                                                            data-period="{{ $period }}">
                                                        <option value="">Select Teacher</option>
                                                        @foreach($teachers as $teacher)
                                                            <option value="{{ $teacher->id }}" {{ $selectedTeacher == $teacher->id ? 'selected' : '' }}>{{ $teacher->first_name }} {{ $teacher->user->personnel_id }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <small class="text-muted availability-status" id="status_{{ $day }}_{{ $period }}"></small>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
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

<script>
$(document).ready(function () {
    $(".teacher-select").on("change", function () {
        const teacherId = $(this).val();
        const day = $(this).data("day");
        const period = $(this).data("period");

        const academic_year_id = $("#academic_year_id").val();
        const shift = $("#shift").val();
        const statusEl = $(`#status_${day}_${period}`);

        statusEl.html('<span class="text-info">Checking...</span>');

        $.ajax({
            url: "{{ route('check.teacher.availability') }}",
            type: "POST",
            data: {
                teacher_id: teacherId,
                day_of_week: day,
                period_number: period,
                academic_year_id: academic_year_id,
                shift: shift,
                _token: "{{ csrf_token() }}"
            },
            success: function (data) {
                if (data.available) {
                    statusEl.html('<span class="text-success">Available</span>');
                } else {
                    statusEl.html('<span class="text-danger">Busy</span>');
                }
            },
            error: function (xhr) {
                if (xhr.status === 409) {
                    // Conflict (teacher busy)
                    const res = xhr.responseJSON;
                    statusEl.html(`<span class="text-danger">${res.message}</span>`);
                } else {
                    statusEl.html('<span class="text-danger">Error checking</span>');
                }
            }
        });
    });
});
</script>

@endpush
