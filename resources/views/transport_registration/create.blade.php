@extends('layouts.al4_main')
@section('transport_mo','menu-open')
@section('transport','active')
@section('manage_transport_registration','active')
@section('title','Register Transport')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Register Transport</a>
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
                    <h3 class="card-title">Register Transport</h3>
                </div>
                <form action="{{ route("transport-registration.store") }}" method="POST" id="saveForm">
                    @csrf
                    <div class="card-body">

                       <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th><input id="check_all" class="formcontrol" type="checkbox"/></th>
                                <th>Personnel ID</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                <th width="30%">Transport Info</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><input class="case" type="checkbox"/></td>
                                <td><input type="text" data-type="personnel_id" name="personnel_id[]" id="personnelId_1"
                                        class="form-control autocomplete_txt" autocomplete="off"></td>
                                <td><input type="text" data-type="first_name" name="first_name[]" id="firstName_1"
                                        class="form-control autocomplete_txt" autocomplete="off"></td>
                                <td><input type="text" data-type="middle_name" name="middle_name[]" id="middleName_1"
                                        class="form-control autocomplete_txt" autocomplete="off"></td>
                                <td><input type="text" data-type="last_name" name="last_name[]" id="lastName_1"
                                        class="form-control autocomplete_txt" autocomplete="off"></td>
                                <td>
                                    <select name="transport_id[]" id="transport_id" class="form-control" required>
                                        <option value="" selected disabled>Select transport</option>
                                        @foreach ($transport_info as $id=>$trInfo)
                                            <option value="{{ $id }}">{{ $trInfo }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="d-none"><input type="hidden" data-type="user_id" name="user_id[]" id="userId_1"
                                                      class="form-control autocomplete_txt" autocomplete="off"></td>
                            </tr>
                            </tbody>
                        </table>

                        <div class="mt-3">
                            <button class="btn btn-danger delete" type="button">- Delete</button>
                            <button class="btn btn-success addmore" type="button">+ Add More</button>
                        </div>
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
                    url: siteURL + '/auto_student_transport',
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
<script>

    //adds extra table rows
        var i= $('table tr').length;
    $(".addmore").on('click',function(){
        html = '<tr>';
        html += '<td><input class="case" type="checkbox"/></td>';
        html += '<td><input type="text" data-type="personnel_id" name="personnel_id[]" id="personnelId_'+i+'" class="form-control autocomplete_txt" autocomplete="off"></td>';
        html += '<td><input type="text" data-type="first_name" name="first_name[]" id="firstName_'+i+'" class="form-control autocomplete_txt" autocomplete="off"></td>';
        html += '<td><input type="text" data-type="middle_name" name="middle_name[]" id="middleName_'+i+'" class="form-control autocomplete_txt" autocomplete="off"></td>';
        html += '<td><input type="text" data-type="last_name" name="last_name[]" id="lastName_'+i+'" class="form-control autocomplete_txt" autocomplete="off"></td>';
        html += '<td><select name="transport_id[]" id="transport_id" class="form-control" required><option value="" selected disabled>Select transport</option>@foreach ($transport_info as $id=>$trInfo)<option value="{{ $id }}">{{ $trInfo }}</option>@endforeach</select></td>';
        html += '<td class="d-none"><input type="hidden" data-type="user_id" name="user_id[]" id="userId_'+i+'" class="form-control autocomplete_txt" autocomplete="off"></td>';
        html += '</tr>';
        $('table').append(html);
        i++;
    });


    //to check all checkboxes
    $(document).on('change','#check_all',function(){
        $('input[class=case]:checkbox').prop("checked", $(this).is(':checked'));
    });


    //deletes the selected table rows
    $(".delete").on('click', function() {
        $('.case:checkbox:checked').parents("tr").remove();
        $('#check_all').prop("checked", false);
    });
</script>
@endpush
