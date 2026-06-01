@extends('layouts.al4_main')
@section('exam_mo','menu-open')
@section('exam','active')
@section('examtype','active')
@section('title','Add Exam Type')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('exam-type')}}" class="nav-link">Manage Exam Type</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Add Exam Type</a>
    </li>
@endsection
@push('css')
@endpush
@section('maincontent')

    <div class="row justify-content-center ">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add Exam Type</h3>
                </div>
                <form action="{{ route("exam-type.store") }}" method="POST" id="saveForm">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row mb-3{{ $errors->has('term_id') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label"> Select Term: <span class="required"> * </span></label>
                            <div class=" col-md-6">
                                <select name="term_id" id="term_id" class="form-control" required>
                                    <option value="" disabled selected>Select Term</option>
                                    @foreach($terms as $id => $name)
                                        <option value="{{ $id }}" {{ old('term_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('term_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('term_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3{{ $errors->has('school_class_id') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label"> Select Class : <span class="required"> * </span></label>
                            <div class=" col-md-6">
                                <select name="school_class_id" id="school_class_id" class="form-control" required>
                                    <option value="" disabled selected>Select Class</option>
                                    @foreach($schoolClasses as $id => $name)
                                        <option value="{{ $id }}" {{ old('school_class_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('school_class_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('school_class_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3{{ $errors->has('subject_id') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label"> Select Subject : <span class="required"> * </span></label>
                            <div class=" col-md-6">
                                <select name="subject_id" id="subject_id" class="form-control" required>

                                </select>
                                @if ($errors->has('subject_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('subject_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class='row'>
                            <table class="table table-bordered table-hover ">
                                <thead>
                                <tr>
                                    <th style="text-align:center">Exam Type</th>
                                    <th style="text-align:center">Full Marks</th>
                                    <th style="text-align:center">Pass Marks</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                            <div class='col-md-3 '></div>
                            <div class='col-md-5 '>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon mt-2" style="margin-right: 15px;">Total Marks Must equal to 100</div>
                                        <input readonly type="number" name="total" step="any" class="form-control" id="subTotal"
                                            placeholder="" style="text-align:right"
                                             ondrop="return false;"
                                            onpaste="return false;">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('all_settings.Back') }}
                        </a>
                        <button type="submit" class="btn btn-success" style="margin-left: 5px" id="saveButton">
                            <i class="fa fa-save" aria-hidden="true"></i> Save
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
<script>
    $('#school_class_id').change(function(){
        var classID = $(this).val();
        if(classID){
            $.ajax({
                type:"GET",
                url:"{{url('get-subjects-by-class')}}/"+classID,
                success:function(res){
                    if(res){
                        $("#subject_id").empty();
                        let defOption = '<option value="">Select Subject</option>';
                        $("#subject_id").append(defOption);
                        $.each(res,function(key,value){
                            $("#subject_id").append('<option value="'+value.id+'">'+value.subject_name+'</option>');
                        });

                    }else{
                        $("#subject_id").empty();
                    }
                }
            });
        }else{
            $("#subject_id").empty();
        }
    });
</script>

<script>

    $('#subject_id').change(function(){
        var classId = $('#school_class_id').val();
        var subjectId = $(this).val();
        if(classId && subjectId){
            $.ajax({
                type:"GET",
                data:{
                    class_id: classId,
                    subject_id: subjectId
                },
                url:"{{ route('getExamCriteriaClassSubject') }}",
                success:function(res){
                    // console.log(res)
                    if(res){
                        $('tbody').empty();
                        $.each(res,function(key,value){
                            let row = '<tr>'+

                                '<td class="col-md-3"><input type="hidden" name="examtype_name[]" value="'+value.exam_criteria_id+'">'+value.exam_criteria.criteria_name+'</td>'+
                                '<td class="col-md-2"><input type="number" step="any" name="full_marks[]" id="full_marks_'+key+'" class="form-control changesNo totalLinePrice" autocomplete="off" style="text-align:right"  ondrop="return false;" onpaste="return false;" value="" required></td>'+
                                '<td class="col-md-2"><input type="number" step="any" name="pass_marks[]" id="pass_marks_'+key+'" class="form-control " autocomplete="off" style="text-align:right"  ondrop="return false;" onpaste="return false;" value="" required></td>'+
                                '</tr>';
                            $('tbody').append(row);
                        });
                        calculateTotal();
                    }else{
                        $('tbody').empty();
                    }
                }
            });
        }else{
            $('tbody').empty();
        }
    });

    $(document).on('keyup change keypress', '.changesNo', function() {
        calculateTotal();
    });

    function calculateTotal(){
        let total = 0;
        $('.totalLinePrice').each(function(){
            let linePrice = $(this).val() ? parseFloat($(this).val()) : 0;
            total += linePrice;
        });
        $('#subTotal').val(total.toFixed(2));
    }


</script>

@endpush
