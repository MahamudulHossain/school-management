<div class="tab-pane" id="academic">

    <div class="card-body">

        @foreach($stu_aca_his as $indexKey =>  $stu_acahis)
        {{-- @dd($indexKey) --}}
            <div class="portlet-body form col-md-12">
                <div class="item_a{{$stu_acahis->id}} ">
                    <div class="row col-md-10 form-horizontal">
                        <div class="row form-group">
                            <label class="col-md-4 control-label "><strong>Academic Year
                                    : </strong></label>
                            <div class="col-md-4">
                                <p class="form-control-static"> {{$stu_acahis->academic_year->title}}</p>
                            </div>
                            @can('StudentAcademicUpdate')
                            <div class="col-md-2">
                                <button data-toggle="modal" data-target="#acahistoryModal" class={!! ($indexKey>0) ? "acahistory-modal btn btn-info btn-xs hidden" : "acahistory-modal btn btn-xs btn-info" !!}
                                        data-acahistory="{{$stu_acahis->id}},{{$stu_acahis->academic_year_id}},{{$stu_acahis->school_section_id}},{{$stu_acahis->school_class_id}},{{$stu_acahis->roll}}"
                                ><span class="fa fa-edit"></span> <strong></strong>
                                </button>
                            </div>
                            @endcan
                        </div>
                        <div class="row form-group ">
                            <label class="col-md-4 control-label "><strong>Class : </strong></label>
                            <div class="col-md-6">
                                <p class="form-control-static"> {{$stu_acahis->student_class->class_name}}</p>
                            </div>
                        </div>
                        <div class="row form-group ">
                            <label class="col-md-4 control-label "><strong>Section/Group
                                    : </strong></label>
                            <div class="col-md-6">
                                <p class="form-control-static"> {{$stu_acahis->student_section->section_name}}</p>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-4 control-label "><strong>Roll : </strong></label>
                            <div class="col-md-6">
                                <p class="form-control-static"> {{$stu_acahis->roll}}</p>
                            </div>
                        </div>
                        <hr/>
                    </div>
                </div>
            </div>

        @endforeach

    </div>

    <div id="acahistoryModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <h4 class="modal-title mb-0"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group d-none">
                            <label class="control-label col-sm-4" for="hid">ID</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="hid" disabled>
                            </div>
                        </div>
                        <div class="row mb-3 form-group">
                            <label class="col-sm-4 control-label"> <strong>Select Academic Year :</strong> <span class="required"> * </span></label>
                            <div class=" col-sm-8">
                                <select name="academic_year_id" id="academic_year_id" class="form-control">
                                    @foreach($academic_year as $id => $title)
                                        <option value="{{ $id }}" {{ $id == $stu_acahis->academic_year_id ? 'selected' : '' }}>
                                            {{ $title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <p class="academic_year_error error text-center alert alert-danger d-none"></p>

                        <div class="row mb-3 form-group">
                            <label class="col-sm-4 control-label"> <strong>Select Class :</strong> <span class="required"> * </span></label>
                            <div class=" col-sm-8">
                                <select name="class_id" id="class_id" class="form-control">
                                    @foreach($schoolClass as $id => $title)
                                        <option value="{{ $id }}" {{ $id == $stu_acahis->class_id ? 'selected' : '' }}>
                                            {{ $title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <p class="klass_error error text-center alert alert-danger d-none"></p>
                        <div class="row mb-3 form-group">
                            <label class="col-sm-4 control-label"> <strong>Select Section:</strong> <span class="required"> * </span></label>
                            <div class=" col-sm-8">
                                <select name="section_id" id="section_id" class="form-control">
                                    @foreach($schoolSection as $id => $title)
                                        <option value="{{ $id }}" {{ $id == $stu_acahis->section_id ? 'selected' : '' }}>
                                            {{ $title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <p class="section_error error text-center alert alert-danger d-none"></p>
                        <div class="row mb-3  form-group">
                            <label class="control-label col-sm-4" for="roll"><strong>Insert Roll No :</strong></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="roll" required>
                            </div>
                        </div>
                        <p class="roll_error error text-center alert alert-danger d-none"></p>
                        <div class="row form-group">
                            <label class="control-label col-sm-4" for="roll"><strong>Rolls Already Been Inserted :</strong></label>
                            <div class="rollsuggestion col-sm-8">
                                <input type="text" class="form-control" id="roll_suggestion" disabled>
                            </div>
                        </div>
                    </form>

                    <div class="acahistorymodal-footer" style="text-align: right">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                        <button type="button" class="btn actionBtn" data-dismiss="modal">
                            <span id="acahistoryfooter_action_button" class='glyphicon'> </span>
                        </button>

                    </div>

                </div>
            </div>
        </div>
    </div>


</div>
@push('js')
<script>

    $(document).on('click', '.acahistory-modal', function () {
        $('#acahistoryfooter_action_button').text(" Update");
        $('#acahistoryfooter_action_button').addClass('glyphicon-check');
        $('#acahistoryfooter_action_button').removeClass('glyphicon-trash');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').removeClass('delete');
        $('.actionBtn').addClass('edit');
        $('.modal-title').text('Academic Info Update');
        $('.deleteContent').hide();
        $('.form-horizontal').show();

        var stuff = $(this).data('acahistory').split(',');
        acahistoryfillmodalData(stuff)
        // console.log(stuff);

        $('#acahistoryModal').modal('show');
    });

    function acahistoryfillmodalData(details) {
        $('#hid').val(details[0]);
        $('#academic_year_id').val(details[1]);
        $('#section_id').val(details[2]);
        $('#class_id').val(details[3]);
        $('#roll').val(details[4]);
    }

    $('.acahistorymodal-footer').on('click', '.edit', function () {
        $.ajax({
            type: 'post',

            url: siteURL + '/student_academic_history_update',
            data: {
                'id': $("#hid").val(),
                'academic_year_id': $('#academic_year_id').val(),
                'section_id': $('#section_id').val(),
                'class_id': $('#class_id').val(),
                'roll': $('#roll').val(),

            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function (data) {
                // console.log(data);
                $('.roll_error').addClass('hidden');


                if (data.errors) {
                    setTimeout(function () {
                        $('#editModal').modal('show');
                        toastr.error("Roll can't be empty!", 'Error Alert', {timeOut: 5000});
                    }, 500);
                    $('#acahistoryModal').modal('show');
                    if (data.errors.roll) {
                        $('.roll_error').removeClass('hidden');
                        $('.roll_error').text("Roll can't be empty !");
                    }
                }
                else {
                    toastr.success('Successfully updated', 'Success Alert', {timeOut: 5000});
                    $('.error').addClass('hidden');
                    location.reload();
                }
            }
        });
    })
    $("select[name='section_id']").change(function () {
        var academic_year_id = $("#academic_year_id").val();
        var school_class_id = $("#class_id").val();
        var school_section_id = $(this).val();

        $.ajax({
            url: siteURL + '/get-inserted-rolls',
            method: 'POST',
            dataType: "json",
            data: {
                academic_year_id: academic_year_id,
                school_class_id: school_class_id,
                school_section_id: school_section_id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                console.log(data)

                if (!$.trim(data)) {
                    var rollsuggestion = "No result Found";
                    $("#roll_suggestion").val(rollsuggestion);
                }
                else
                    var rollsuggestion = data;
                $("#roll_suggestion").val(rollsuggestion);

            }
        });
    });

    $(document).on('hidden.bs.modal', '#acahistoryModal', function () {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    });

</script>

@endpush
