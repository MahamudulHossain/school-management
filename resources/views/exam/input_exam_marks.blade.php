@extends('layouts.al4_main')
@section('exam_mo','menu-open')
@section('exam','active')
@section('manage_marks','active')
@section('title','Input Exam Marks')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Input Marks</a>
    </li>
@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('alte4/plugins/select2/css/select2.min.css') }}">
@endpush
@section('maincontent')
    <div class="row justify-content-center ">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Input Exam Marks</h3>
                </div>
                <form action="{{ route("exam.input_exam_marks") }}" method="POST" id="saveForm">

                    <input type="hidden" name="school_class_id" value="{{$school_class->id}}">
                    <input type="hidden" name="school_section_id" value="{{$school_section->id}}">
                    <input type="hidden" name="subject_id" value="{{$examtype->subject_id}}">
                    <input type="hidden" name="academic_year_id" value="{{$academic_year->id}}">
                    <input type="hidden" name="examtype_id" value="{{$examtype->id}}">
                    <input type="hidden" name="full_marks" value="{{$examtype->full_marks}}">
                    <input type="hidden" name="examtype_name" value="{{$examtype->examtype_name}}">
                    @csrf
                    <div class="card-body">
                        <div class="form-body" style="margin-bottom: 5px">
                            <span class="text-muted ">Class : </span>{{$school_class->class_name.', '}}
                            <span class="text-muted">Section: </span>{{$school_section->section_name.', '}}
                            <span class="text-muted">Subject: </span>{{$examtype->subject->subject_name.', '}}<br/>
                            <span class="text-muted">Exam Type: </span>{{$examtype->examtype_name}}<br/>
                            <span class="text-muted">Exam Taken Mark: </span>{{$examTakenMark}}<br/>
                            <input type="hidden" name="examTakenMark" value="{{$examTakenMark}}">
                        </div>

                        <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <th class="col-xs-1">S.No</th>
                            <th class="col-xs-1"> Student Name</th>
                            <th class="col-xs-1">Roll No</th>
                            <th class="col-xs-1">Full Marks</th>
                            <th class="col-xs-1">Pass Marks</th>
                            <th class="col-xs-3">Obtained Marks</th>
                            <th class="col-xs-3">Marks will be added</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($students as $key => $stu)
                        {{-- @dd($stu) --}}
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    {{ $stu->user->student->first_name }} {{ $stu->user->student->last_name }}
                                    <input type="hidden" name="user_id[]" value="{{$stu->user_id}}">
                                </td>
                                <td>
                                    {{$stu->roll}}
                                    <input type="hidden" name="roll[]" value="{{$stu->roll}}">
                                </td>
                                <td>{{$examtype->full_marks}}</td>
                                <td>{{$examtype->pass_marks}}</td>
                                <td>
                                    <div class="form-group">
                                        <div class="col-md-10">
                                            <input type="number" name="obtain_marks[]" class="form-control changesNo" id="obtain_marks_{{ $stu->user_id }}" step="0.01" value="{{ $stu->obtain_mark }}" required>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div class="col-md-10">
                                            <input type="number" name="added_marks[]" class="form-control" id="noWillBeAdded_{{ $stu->user_id }}" value="{{ $stu->added_mark }}" step="0.01" readonly>
                                        </div>
                                    </div>
                                </td>
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
    $(document).on('keyup change keypress', '.changesNo', function() {
        calculateAddedMark();
    });

    function calculateAddedMark() {
        @foreach($students as $key => $stu)
            var obtain_marks_{{ $stu->user_id }} = parseFloat($('#obtain_marks_{{ $stu->user_id }}').val()) || 0;
            var exam_full_marks = parseFloat({{ $examtype->full_marks }});
            var exam_taken_mark = parseFloat({{ $examTakenMark }});

            var marks_will_be_added = (obtain_marks_{{ $stu->user_id }} / exam_taken_mark) * exam_full_marks;

            $('#noWillBeAdded_{{ $stu->user_id }}').val(marks_will_be_added.toFixed(2));
        @endforeach
    }



</script>
@endpush
