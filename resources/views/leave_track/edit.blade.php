@extends('layouts.al4_main')
@section('leave_mo','menu-open')
@section('leave','active')
@section('list_leave','active')
@section('title','Leave Management')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('leave-track')}}" class="nav-link">Leave</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Manage Leave</a>
    </li>
@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('alte4/plugins/select2/css/select2.min.css') }}">
{{--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />--}}
{{--<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />--}}
<link rel="stylesheet" href="{{ asset('alte4/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
@endpush
@section('maincontent')

    <div class="row justify-content-center ">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Update Leave</h3>
                </div>
                <form action="{{ route("leave-track.update", $leave_track->id) }}" method="POST" id="saveForm">
                    @csrf
                    @method('PUT')
                    <div class="card-body">

                       <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Personnel ID</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                @if($leave_track->user->user_type_id == 3)
                                    <td><input type="text" data-type="personnel_id" name="personnel_id" id="personnelId_1"
                                            class="form-control autocomplete_txt" autocomplete="off" value="{{$leave_track->user->personnel_id}}"></td>
                                    <td><input type="text" data-type="first_name" name="first_name" id="firstName_1"
                                            class="form-control autocomplete_txt" autocomplete="off" value="{{$leave_track->user->teacher->first_name}}"></td>
                                    <td><input type="text" data-type="middle_name" name="middle_name" id="middleName_1"
                                            class="form-control autocomplete_txt" autocomplete="off" value="{{$leave_track->user->teacher->middle_name}}"></td>
                                    <td><input type="text" data-type="last_name" name="last_name" id="lastName_1"
                                            class="form-control autocomplete_txt" autocomplete="off" value="{{$leave_track->user->teacher->last_name}}"></td>
                                    <td class="d-none"><input type="hidden" data-type="user_id" name="user_id" id="userId_1"
                                                        class="form-control autocomplete_txt" autocomplete="off" value="{{$leave_track->user_id}}"></td>
                                @endif

                                @if($leave_track->user->user_type_id == 4)
                                    <td><input type="text" data-type="personnel_id" name="personnel_id" id="personnelId_1"
                                            class="form-control autocomplete_txt" autocomplete="off" value="{{$leave_track->user->personnel_id}}"></td>
                                    <td><input type="text" data-type="first_name" name="first_name" id="firstName_1"
                                            class="form-control autocomplete_txt" autocomplete="off" value="{{$leave_track->user->employee->first_name}}"></td>
                                    <td><input type="text" data-type="middle_name" name="middle_name" id="middleName_1"
                                            class="form-control autocomplete_txt" autocomplete="off" value="{{$leave_track->user->employee->middle_name}}"></td>
                                    <td><input type="text" data-type="last_name" name="last_name" id="lastName_1"
                                            class="form-control autocomplete_txt" autocomplete="off" value="{{$leave_track->user->employee->last_name}}"></td>
                                    <td class="d-none"><input type="hidden" data-type="user_id" name="user_id" id="userId_1"
                                                        class="form-control autocomplete_txt" autocomplete="off" value="{{$leave_track->user_id}}"></td>
                                @endif

                                @if($leave_track->user->user_type_id == 2)
                                    <td><input type="text" data-type="personnel_id" name="personnel_id" id="personnelId_1"
                                            class="form-control autocomplete_txt" autocomplete="off" value="{{$leave_track->user->personnel_id}}"></td>
                                    <td><input type="text" data-type="first_name" name="first_name" id="firstName_1"
                                            class="form-control autocomplete_txt" autocomplete="off" value="{{$leave_track->user->student->first_name}}"></td>
                                    <td><input type="text" data-type="middle_name" name="middle_name" id="middleName_1"
                                            class="form-control autocomplete_txt" autocomplete="off" value="{{$leave_track->user->student->middle_name}}"></td>
                                    <td><input type="text" data-type="last_name" name="last_name" id="lastName_1"
                                            class="form-control autocomplete_txt" autocomplete="off" value="{{$leave_track->user->student->last_name}}"></td>
                                    <td class="d-none"><input type="hidden" data-type="user_id" name="user_id" id="userId_1"
                                                        class="form-control autocomplete_txt" autocomplete="off" value="{{$leave_track->user->id}}"></td>
                                @endif
                            </tr>
                            </tbody>
                        </table>

                        <div class="row mt-3">
                            <div class="form-group row mb-3">
                                <label class="col-md-2 control-label"> Leave Start Date :</label>
                                <div class="col-md-4">
                                    <input type="date" name="start_date" class="form-control" value="{{$leave_track->start_date}}" required>
                                </div>
                                <label class="col-md-2 control-label"> Start portion:</label>
                                <div class="col-md-4 ">
                                    <select name="start_portion" class="form-control">
                                        <option value="00:00:00" {{ $leave_track->start_portion == '00:00:00' ? 'selected' : '' }}>First Half Start</option>
                                        <option value="12:00:00" {{ $leave_track->start_portion == '12:00:00' ? 'selected' : '' }}>Second Half Start</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-md-2 control-label"> Leave End Date :</label>
                                <div class="col-md-4">
                                    <input type="date" name="end_date" class="form-control" value="{{$leave_track->end_date}}" required>
                                </div>
                                <label class="col-md-2 control-label"> End Portion:</label>
                                <div class="col-md-4">
                                    <select name="end_portion" class="form-control">
                                        <option value="23:59:59" {{ $leave_track->end_portion == '23:59:59' ? 'selected' : '' }}>Second Half End</option>
                                        <option value="11:59:59" {{ $leave_track->end_portion == '11:59:59' ? 'selected' : '' }}>First Half End</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-md-2 control-label "> Select Leave Type:</label>
                                <div class="col-md-4 ">
                                    <select name="leave_type_id" id="leave_type" class="form-control" required>
                                        <option value="" disabled selected>--- Select Leave Type ---</option>
                                        @foreach($leave_types as $id => $name)
                                            <option value="{{ $id }}" {{ $leave_track->leave_type_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-md-2 control-label "> Comments:</label>
                                <div class="col-md-4 ">
                                    <textarea name="comments" class="form-control" cols="30" rows="5">{{ $leave_track->comments }}</textarea>
                                </div>
                            </div>
                        </div>
                        @if(!in_array(Auth::user()->user_type_id,[2,5])) {{-- Except Student and Guardian --}}
                        <div class="row mt-3">
                            <div class="form-group row mb-3">
                                <label class="col-md-2 control-label">Update Leave Status</label>
                                <div class="col-md-4 ">
                                    <select name="status" class="form-control">

                                        <option value="applied" {{ $leave_track->status == 'applied' ? 'selected':'' }}>Applied</option>

                                        <option value="requested_for_approval" {{ $leave_track->status == 'requested_for_approval' ? 'selected':'' }}>Requested For Approval</option>

                                        @if(in_array(Auth::user()->user_type_id,[1,4])) {{-- Only Admin and Employee --}}
                                        <option value="approved" {{ $leave_track->status == 'approved' ? 'selected':'' }}>Approved</option>
                                        @endif
                                        <option value="reject" {{ $leave_track->status == 'reject' ? 'selected':'' }}>Rejected</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        {{-- <a href="{{ url()->previous() }}" class="btn btn-outline-primary"><i
                                    class="fa fa-arrow-left"
                                    aria-hidden="true"></i>{{ __('all_settings.Back') }}</a> --}}
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
<script src="{!! asset('custom/js/autocomplete.js')!!}"></script>


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


//autocomplete script
$(document).ready(function() {
    $(document).on('focus','.autocomplete_txt',function(){
        var type = $(this).data('type');
        var autoTypeNo;

        if(type =='first_name' ) autoTypeNo=0;
        if(type =='middle_name' ) autoTypeNo=1;
        if(type =='last_name' ) autoTypeNo=2;
        if(type =='personnel_id' ) autoTypeNo=3;

        $(this).autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: './auto_user_leave',
                    dataType: "json",
                    method: 'post',
                    data: {
                        name_startsWith: request.term,
                        type: type
                    },
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            var code = item.split("|");
                            return {
                                label: code[autoTypeNo],
                                value: code[autoTypeNo],
                                data: item
                            }
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 0,
            select: function(event, ui) {
                var names = ui.item.data.split("|");
                var id_arr = $(this).attr('id');
                var id = id_arr.split("_");
                $('#firstName_'+id[1]).val(names[0]);
                $('#middleName_'+id[1]).val(names[1]);
                $('#lastName_'+id[1]).val(names[2]);
                $('#personnelId_'+id[1]).val(names[3]);
                $('#id_'+id[1]).val(names[4]);
                $('#userId_'+id[1]).val(names[5]);
            }
        });
    });
});


</script>
@endpush
