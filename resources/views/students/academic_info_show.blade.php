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

</div>
@push('js')

@endpush
