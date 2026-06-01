@extends('layouts.al4_main')
@section('leave_mo','menu-open')
@section('leave','active')
@section('add_leave','active')
@section('title','Add Leave')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('leave-track')}}" class="nav-link">Leave</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Add Leave</a>
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
                    <h3 class="card-title">Add Leave</h3>
                </div>
                <form action="{{ route("leave-track.store") }}" method="POST" id="saveForm">
                    @csrf
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
                                <td><input type="text" data-type="personnel_id" name="personnel_id" id="personnelId_1"
                                        class="form-control autocomplete_txt" autocomplete="off"></td>
                                <td><input type="text" data-type="first_name" name="first_name" id="firstName_1"
                                        class="form-control autocomplete_txt" autocomplete="off"></td>
                                <td><input type="text" data-type="middle_name" name="middle_name" id="middleName_1"
                                        class="form-control autocomplete_txt" autocomplete="off"></td>
                                <td><input type="text" data-type="last_name" name="last_name" id="lastName_1"
                                        class="form-control autocomplete_txt" autocomplete="off"></td>
                                <td class="d-none"><input type="hidden" data-type="user_id" name="user_id" id="userId_1"
                                                      class="form-control autocomplete_txt" autocomplete="off"></td>
                            </tr>
                            </tbody>
                        </table>

                        <div class="row mt-3">
                            <div class="form-group row mb-3">
                                <label class="col-md-2 control-label"> Leave Start Date :</label>
                                <div class="col-md-4">
                                    <input type="date" name="start_date" class="form-control" required>
                                </div>
                                <label class="col-md-2 control-label"> Start portion:</label>
                                <div class="col-md-4 ">
                                    <select name="start_portion" class="form-control">
                                        <option value="00:00:00">First Half Start</option>
                                        <option value="12:00:00">Second Half Start</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-md-2 control-label"> Leave End Date :</label>
                                <div class="col-md-4">
                                    <input type="date" name="end_date" class="form-control" required>
                                </div>
                                <label class="col-md-2 control-label"> End Portion:</label>
                                <div class="col-md-4">
                                    <select name="end_portion" class="form-control">
                                        <option value="23:59:59">Second Half End</option>
                                        <option value="11:59:59">First Half End</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-md-2 control-label "> Select Leave Type:</label>
                                <div class="col-md-4 ">
                                    <select name="leave_type_id" id="leave_type" class="form-control" required>
                                        <option value="" disabled selected>--- Select Leave Type ---</option>
                                        @foreach($leave_types as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-md-2 control-label "> Comments:</label>
                                <div class="col-md-4 ">
                                    <textarea name="comments" class="form-control" cols="30" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
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
