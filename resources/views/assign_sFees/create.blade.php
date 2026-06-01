@extends('layouts.al4_main')
@section('accounting_mo','menu-open')
@section('accounting','active')
@section('assign_sFee','active')
@section('title','Assign Fee')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Assign Fee</a>
    </li>
@endsection
@section('maincontent')
    <div class="row justify-content-center ">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Assign Fee</h3>
                </div>
                <form action="{{ route("store.assign-fees") }}" method="POST" id="saveForm">

                    <input type="hidden" name="due_date" value="{{$due_date}}">
                    <input type="hidden" name="academic_year_id" value="{{$academic_year_id}}">
                    <input type="hidden" name="accounting_sfee_id" value="{{$accounting_sfee_id}}">
                    @csrf
                    <div class="card-body">
                        <div class="form-body" style="margin-bottom: 5px">
                            <span class="text-muted ">Student Fee : </span>{{$student_fee->fee_name.', '}}
                            <span class="text-muted">Due Date: </span>{{$due_date}}
                        </div>

                        <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <th class="col-xs-1">S.No</th>
                            <th class="col-xs-2">Student ID</th>
                            <th class="col-xs-2">Student Name</th>
                            <th class="col-xs-3">Fee Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($students as $key => $stu)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $stu->personnel_id }}</td>
                                <td>
                                    {{ $stu->first_name }} {{ $stu->last_name }}
                                    <input type="hidden" name="user_id[]" value="{{$stu->user_id}}">
                                </td>
                                <td>
                                    <input type="number" name="fee_amount[]" value="{{ $student_fee->amount }}" required>
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
{{--prevent multiple form submits (Jquery needed)--}}
<script>
    $('#saveForm').submit(function () {
        $("#saveButton", this)
            .html("Please Wait...")
            .attr('disabled', 'disabled');
        return true;
    });
</script>
@endpush
