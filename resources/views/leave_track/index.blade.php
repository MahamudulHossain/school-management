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
<link rel="stylesheet" href="{{ asset('supporting/dataTables/bs4/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('supporting/dataTables/fixedHeader.dataTables.min.css') }}">
{{--<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.dataTables.min.css">--}}

@endpush
@section('maincontent')
    <div class="card card-tabs">
        <div class="card-header p-2 pt-1">
            <ul class="nav nav-pills">
                @can('ManageTeacherLeave')
                <li class="nav-item"><a class="nav-link {{ $activeTab == 'teacher' ? 'active': '' }}" href="#teacher" data-toggle="tab">Teacher Leave</a>
                </li>
                @endcan
                @can('ManageEmployeeLeave')
                    <li class="nav-item"><a class="nav-link" href="#staff" data-toggle="tab">Employee Leave</a></li>
                @endcan
                @can('ManageStudentLeave')
                <li class="nav-item"><a class="nav-link {{ $activeTab == 'student' ? 'active': '' }}" href="#student" data-toggle="tab">Student Leave</a>
                </li>
                @endcan
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                @can('ManageTeacherLeave')
                <div class="tab-pane {{ $activeTab == 'teacher' ? 'active': '' }}"  id="teacher">
                    <div class="p-2">
                        <div class="bg-info p-2 mb-3">
                            <div class="caption">
                                <i class="fa fa-gift"> </i>Manage Teacher Leave
                            </div>
                        </div>

                        <div class="portlet-body">
                            {{--@include('partials.flash_message')--}}
                            <div class="form-body">
                                <table class="table dataTables table-striped table-bordered table-hover"
                                    id="sample_6">
                                    <thead>
                                    <tr>
                                        <th>Picture</th>
                                        <th>Teacher Name <br/>Personnel ID</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Total Day</th>
                                        <th>Leave Type</th>
                                        <th>Comments</th>
                                        <th>Status</th>
                                        <th class="noprint">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($leave_all as $leave)
                                        @if($leave->user->user_type_id == 3)
                                        <tr>
                                            <td>
                                                @if($leave->user->imageprofile->image_name==null)
                                                    <img src="{!! asset( 'storage/images/avatar_male'.'.jpg'. '?'. 'time='. time()) !!}" class="profile-user-img img-fluid img-circle" style="-webkit-user-select:none; width: 40px; height: 40px; display:block; margin:auto;">
                                                @else
                                                    <img src="{!! asset( 'storage/image_profile/'. $leave->user->imageprofile->image. '?'. 'time='. time()) !!}" class="profile-user-img img-fluid img-circle" alt="User Image">
                                                @endif
                                            </td>
                                            <td>{{ $leave->user->teacher->first_name.' '.$leave->user->teacher->middle_name.' '.$leave->user->teacher->last_name}}
                                                <br/>{{ $leave->user->personnel_id }}</td>
                                            <td>{{$date=date('Y-m-d', strtotime($leave->start_date))}} <br/>{{($leave->start_portion=='00:00:00') ? ' First Half Start' : ' Second Half Start'}}  </td>
                                            <td>{{$date=date('Y-m-d', strtotime($leave->end_date))}}   <br/>{{($leave->end_portion=='11:59:59') ? ' First Half End' : ' Second Half End'}} </td>
                                            <td>{{round((((strtotime($leave->end_date.' '.$leave->end_portion))-(strtotime($leave->start_date.' '.$leave->start_portion)))/86400),2)}} </td>
                                            <td>{{ $leave->leave_type->leave_type_name }}</td>
                                            <td>{{$leave->comments}}</td>
                                            <td>
                                                @if($leave->status == 'applied')
                                                    <span class="badge text-bg-primary">Applied</span>
                                                @elseif ($leave->status == 'requested_for_approval')
                                                    <span class="badge text-bg-warning">Requested For Approval</span>
                                                @elseif($leave->status == 'approved')
                                                    <span class="badge text-bg-success">Approved</span>
                                                @else
                                                    <span class="badge text-bg-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td class="noprint">
                                                @if($leave->status == 'applied' || in_array(Auth::user()->user_type_id,[1,4]))
                                                <a href="{{ url('leave-track/' . $leave->id . '/edit') }}" class="btn btn-info btn-sm" title="Edit"><span class="far fa-edit" aria-hidden="true"></span></a>
                                                @endif
                                                @if(Auth::user()->can('DeleteLeave') || $leave->status == 'applied')
                                                <form method="POST" action="{{ url('leave-track/' . $leave->id) }}" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                        class="btn btn-danger btn-sm"
                                                        title="Delete"
                                                        onclick="return confirm('Confirm delete?')">
                                                        <span class="far fa-trash-alt" aria-hidden="true" title="Delete"></span>
                                                    </button>
                                                </form>
                                                @endif
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
                @can('ManageEmployeeLeave')
                    <div class="tab-pane"  id="staff">
                        <div class="p-2">
                            <div class="bg-info p-2 mb-3">
                                <div class="caption">
                                    <i class="fa fa-gift"> </i>Manage Staff Leave
                                </div>
                            </div>

                            <div class="portlet-body">
                                {{--@include('partials.flash_message')--}}
                                <div class="form-body">
                                    <table class="table dataTables table-striped table-bordered table-hover"
                                        id="sample_3">
                                        <thead>
                                        <tr>
                                            <th>Picture</th>
                                            <th> Staff Name <br/>Personnel ID</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Total Day</th>
                                            <th>Leave Type</th>
                                            <th>Comments</th>
                                            <th>Status</th>
                                            <th class="noprint">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($leave_all as $leave)
                                            @if($leave->user->user_type_id == 4)
                                                <tr>
                                                    <td>
                                                        @if($leave->user->imageprofile->image_name==null)
                                                            <img src="{!! asset( 'storage/images/avatar_male'.'.jpg'. '?'. 'time='. time()) !!}" class="profile-user-img img-fluid img-circle" style="-webkit-user-select:none; width: 40px; height: 40px; display:block; margin:auto;">
                                                        @else
                                                            <img src="{!! asset( 'storage/image_profile/'. $leave->user->imageprofile->image. '?'. 'time='. time()) !!}" class="profile-user-img img-fluid img-circle" alt="User Image">
                                                        @endif
                                                    </td>
                                                    <td>{{ $leave->user->employee->first_name.' '.$leave->user->employee->middle_name.' '.$leave->user->employee->last_name}}
                                                        <br/>{{ $leave->user->personnel_id }}</td>
                                                    <td>{{$date=date('Y-m-d', strtotime($leave->start_date))}} <br/>{{($leave->start_portion=='00:00:00') ? ' First Half Start' : ' Second Half Start'}}  </td>
                                                    <td>{{$date=date('Y-m-d', strtotime($leave->end_date))}}   <br/>{{($leave->end_portion=='11:59:59') ? ' First Half End' : ' Second Half End'}} </td>
                                                    <td>{{round((((strtotime($leave->end_date.' '.$leave->end_portion))-(strtotime($leave->start_date.' '.$leave->start_portion)))/86400),2)}} </td>
                                                    <td>{{ $leave->leave_type->leave_type_name }}</td>
                                                    <td>{{$leave->comments}}</td>
                                                    <td>
                                                        @if($leave->status == 'applied')
                                                            <span class="badge text-bg-primary">Applied</span>
                                                        @elseif ($leave->status == 'requested_for_approval')
                                                            <span class="badge text-bg-warning">Requested For Approval</span>
                                                        @elseif($leave->status == 'approved')
                                                            <span class="badge text-bg-success">Approved</span>
                                                        @else
                                                            <span class="badge text-bg-danger">Rejected</span>
                                                        @endif
                                                    </td>
                                                    <td class="noprint">
                                                        @if($leave->status == 'applied' || in_array(Auth::user()->user_type_id,[1,4]))
                                                        <a href="{{ url('leave-track/' . $leave->id . '/edit') }}" class="btn btn-info btn-sm" title="Edit"><span class="far fa-edit" aria-hidden="true"></span></a>
                                                        @endif
                                                        @if(Auth::user()->can('DeleteLeave') || $leave->status == 'applied')
                                                        <form method="POST" action="{{ url('leave-track/' . $leave->id) }}" style="display:inline">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm"
                                                                title="Delete"
                                                                onclick="return confirm('Confirm delete?')">
                                                                <span class="far fa-trash-alt" aria-hidden="true" title="Delete"></span>
                                                            </button>
                                                        </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
                @can('ManageStudentLeave')
                <div class="tab-pane {{ $activeTab == 'student' ? 'active': '' }}" id="student">
                    <div class="p-2">
                        <div class="bg-info p-2 mb-3">
                            <div class="caption">
                                <i class="fa fa-gift"> </i>Manage Student Leave
                            </div>
                        </div>

                        <div class="portlet-body">
                            {{--@include('partials.flash_message')--}}
                            <div class="form-body">
                                <table class="table dataTables2 table-striped table-bordered table-hover"
                                    id="sample_5">
                                    <thead>
                                    <tr>

                                        <th>Picture</th>
                                        <th> Student Name <br/>Personnel ID</th>
                                        <th>Class, Section & Roll No</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Total Day</th>
                                        <th>Leave Type</th>
                                        <th>Comments</th>
                                        <th>Status</th>
                                        <th class="noprint">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($leave_all as $leave)
                                        @if($leave->user->user_type_id == 2)
                                            <tr>
                                                <td>
                                                    @if($leave->user->imageprofile->image_name==null)
                                                        <img src="{!! asset( 'storage/images/avatar_male'.'.jpg'. '?'. 'time='. time()) !!}" class="profile-user-img img-fluid img-circle" style="-webkit-user-select:none; width: 40px; height: 40px; display:block; margin:auto;">
                                                    @else
                                                        <img src="{!! asset( 'storage/image_profile/'. $leave->user->imageprofile->image. '?'. 'time='. time()) !!}" class="profile-user-img img-fluid img-circle" alt="User Image">
                                                    @endif
                                                </td>
                                                <td>{{ $leave->user->student->first_name.' '.$leave->user->student->middle_name.' '.$leave->user->student->last_name}}
                                                    <br/>{{ $leave->user->personnel_id }}</td>
                                                <td><?php
                                                    $class = DB::table('student_academic_histories')
                                                        ->select('school_classes.class_name', 'school_sections.section_name', 'student_academic_histories.roll')
                                                        ->join('school_classes', 'student_academic_histories.school_class_id', '=', 'school_classes.id')
                                                        ->join('school_sections', 'student_academic_histories.school_section_id', '=', 'school_sections.id')
                                                        ->where('student_academic_histories.user_id', $leave->user->id)->first();
                                                    //                                        echo ($class->class_name) ;
                                                    ?>
                                                    {{$class->class_name}} <br/>{{$class->section_name}}<br/>Roll
                                                    No:{{$class->roll}}
                                                </td>
                                                <td>{{$date=date('Y-m-d', strtotime($leave->start_date))}} <br/>{{($leave->start_portion=='00:00:00') ? ' First Half Start' : ' Second Half Start'}}  </td>
                                                <td>{{$date=date('Y-m-d', strtotime($leave->end_date))}}   <br/>{{($leave->end_portion=='11:59:59') ? ' First Half End' : ' Second Half End'}} </td>
                                                <td>{{round((((strtotime($leave->end_date.' '.$leave->end_portion))-(strtotime($leave->start_date.' '.$leave->start_portion)))/86400),2)}} </td>
                                                <td>{{ $leave->leave_type->leave_type_name }}</td>
                                                <td>{{$leave->comments}}</td>
                                                <td>
                                                    @if($leave->status == 'applied')
                                                        <span class="badge text-bg-primary">Applied</span>
                                                    @elseif ($leave->status == 'requested_for_approval')
                                                        <span class="badge text-bg-warning">Requested For Approval</span>
                                                    @elseif($leave->status == 'approved')
                                                        <span class="badge text-bg-success">Approved</span>
                                                    @else
                                                        <span class="badge text-bg-danger">Rejected</span>
                                                    @endif
                                                </td>
                                                <td class="noprint">
                                                    @if($leave->status == 'applied' || in_array(Auth::user()->user_type_id,[1,4])) {{-- only admin and employee --}}
                                                    <a href="{{ url('leave-track/' . $leave->id . '/edit') }}" class="btn btn-info btn-sm" title="Edit"><span class="far fa-edit" aria-hidden="true"></span></a>
                                                    @endif
                                                    @if(Auth::user()->can('DeleteLeave') || $leave->status == 'applied')
                                                    <form method="POST" action="{{ url('leave-track/' . $leave->id) }}" style="display:inline">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                            class="btn btn-danger btn-sm"
                                                            title="Delete"
                                                            onclick="return confirm('Confirm delete?')">
                                                            <span class="far fa-trash-alt" aria-hidden="true" title="Delete"></span>
                                                        </button>
                                                    </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan

            </div>
        </div>
    </div>
@endsection

@push('js')
<script src="{{ asset('supporting/dataTables/bs4/datatables.min.js')}}"></script>
<script src="{{ asset('supporting/dataTables/dataTables.fixedHeader.min.js')}}"></script>

<script>
    $(document).ready(function () {
        $('.dataTables').DataTable({
            aaSorting: [],
            lengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"] // change per page values here
            ],
            pageLength: 25,
            responsive: true,
            fixedHeader: true,
//            dom: '<"html5buttons"B>lTfgtip',
            'dom': "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            columnDefs: [
//                { targets: [ 0,1,2,3,4, 5, 6, 7, 8, 9 ], className: 'dt-head text-center'  },
//                { targets: [0,1,2,3,4, 5,6,7 ], className: 'text-center' },
                {targets: [0, 1, 2,3,4,5,6,7,8 ], className: 'text-center'},
//                {targets: [4], className: 'text-right'},
            ],

            buttons: [
                {extend: 'copy'},
                {extend: 'csv'},
                {
                    extend: 'excel', title: '{{ config('app.name', 'EISL') }}',
                    messageTop: ' Leave   '
                },
                    {{--{extend: 'pdf', title: 'DVL Transaction Data',--}}
                    {{--messageTop: 'Commission Report of {{entryBy($partner_id).' '. $title_date_range}} ',--}}
                    {{--messageBottom: '{{\Carbon\Carbon::now()->format(' D, d-M-Y, h:ia')}}'--}}
                    {{--},--}}

                {
                    extend: 'pdfHtml5',

                    className: 'btn  btn-sm btn-table',
                    titleAttr: 'Export to Pdf',
                    text: '<span class="fa fa-file-pdf-o fa-lg"></span><i class="hidden-xs hidden-sm hidden-md"> Pdf</i>',
                    filename: 'Leave ',
                    extension: '.pdf',
//                    orientation : 'landscape',
                    orientation: 'portrait',
                    title: "Leave ",
                    footer: true,
                    exportOptions: {
                        columns: ':not(.noprint)',
                        orthogonal: "Export-pdf"
                    },
                    customize: function (doc) {
                        var rowCount = doc.content[1].table.body.length;
                        for (i = 1; i < rowCount; i++) {

                            /*var val = document.form1.campo.value;
                             if (isNaN(val)){
                             alert(‘Il valore inserito non è numerico’);
                             } else {
                             alert(‘Il valore inserito è numerico’);
                             }*/
                            doc.content[1].table.body[i][0].alignment = 'center';
                            doc.content[1].table.body[i][1].alignment = 'left';
                            doc.content[1].table.body[i][2].alignment = 'left';
                            doc.content[1].table.body[i][3].alignment = 'left';
                           doc.content[1].table.body[i][4].alignment = 'left';
                           doc.content[1].table.body[i][5].alignment = 'left';
                           doc.content[1].table.body[i][6].alignment = 'left';
                           doc.content[1].table.body[i][7].alignment = 'left';
                        }
                        doc.content[1].table.widths = ['10%','10%','10%','10%','10%', '10%', '20%', '20%'];
//                        doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        doc.content.splice(0, 1);
                        var now = new Date();
                        var jsDate = now.getDate() + '-' + (now.getMonth() + 1) + '-' + now.getFullYear() + ' ' + now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds();
                        var logo = '';
                        {{--var header_title = '';--}}
                            doc.pageMargins = [10, 50, 10, 40];
                        doc.defaultStyle.fontSize = 7;

                        doc.defaultStyle.alignment = 'left';
                        doc.styles.tableHeader.alignment = 'left';
                        doc.styles.tableHeader.fontSize = 10;
                        doc.styles.tableFooter.fontSize = 10;
                        doc['header'] = (function () {
                            return {
                                columns: [
                                    {
                                        alignment: 'left',
                                        italics: true,
                                        text: 'Leave ',
                                        fontSize: 10,
                                        margin: [10, 0]
                                    },
                                    // {
                                    //     //image: logo,
                                    //     alignment: 'center',
                                    //     width: 20,
                                    //     height: 20,
                                    //     {{--image: 'data:image/png;base64,{{$settings->logo_base64}}'--}}

                                    // },

                                    {
                                        alignment: 'right',
                                        fontSize: 10,
                                        text: '{{ config('app.name', 'EISL') }}'
                                    }
                                ],
                                margin: 20
                            };
                        });
                        doc['footer'] = (function (page, pages) {
                            return {
                                columns: [
                                    {
                                        alignment: 'left',
                                        text: ['Print On: ', {text: jsDate.toString()}]
                                    },

                                    {
                                        alignment: 'right',
                                        text: ['Pages ', {text: page.toString()}, ' of ', {text: pages.toString()}]
                                    }
                                ],
                                margin: 20
                            };
                        });
                        var objLayout = {};
                        objLayout['hLineWidth'] = function (i) {
                            return .5;
                        };
                        objLayout['vLineWidth'] = function (i) {
                            return .5;
                        };
                        objLayout['hLineColor'] = function (i) {
                            return '#aaa';
                        };
                        objLayout['vLineColor'] = function (i) {
                            return '#aaa';
                        };
                        objLayout['paddingLeft'] = function (i) {
                            return 4;
                        };
                        objLayout['paddingRight'] = function (i) {
                            return 4;
                        };
                        doc.content[0].layout = objLayout;
                    }
                },
                {
                    extend: 'print',
                    footer: true,
                    messageTop: 'Leave  ',
                    messageBottom: '{{'Printed On: '.\Carbon\Carbon::now()->format(' D, d-M-Y, h:ia')}}',
                    exportOptions: {
                        columns: ':not(.noprint)',
                        orthogonal: "Export-pdf"
                    },
                    customize: function (win) {
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');
                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }
            ]

        });
    });


        $('.dataTables2').DataTable({
            aaSorting: [],
            lengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"] // change per page values here
            ],
            pageLength: 25,
            responsive: true,
            fixedHeader: true,
//            dom: '<"html5buttons"B>lTfgtip',
            'dom': "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            columnDefs: [
//                { targets: [ 0,1,2,3,4, 5, 6, 7, 8, 9 ], className: 'dt-head text-center'  },
//                { targets: [0,1,2,3,4, 5,6,7 ], className: 'text-center' },
                {targets: [0, 1, 2,3,4,5,6,7,8,9 ], className: 'text-center'},
//                {targets: [4], className: 'text-right'},
            ],

            buttons: [
                {extend: 'copy'},
                {extend: 'csv'},
                {
                    extend: 'excel', title: '{{ config('app.name', 'EISL') }}',
                    messageTop: ' Leave   '
                },
                    {{--{extend: 'pdf', title: 'DVL Transaction Data',--}}
                    {{--messageTop: 'Commission Report of {{entryBy($partner_id).' '. $title_date_range}} ',--}}
                    {{--messageBottom: '{{\Carbon\Carbon::now()->format(' D, d-M-Y, h:ia')}}'--}}
                    {{--},--}}

                {
                    extend: 'pdfHtml5',

                    className: 'btn  btn-sm btn-table',
                    titleAttr: 'Export to Pdf',
                    text: '<span class="fa fa-file-pdf-o fa-lg"></span><i class="hidden-xs hidden-sm hidden-md"> Pdf</i>',
                    filename: 'Leave ',
                    extension: '.pdf',
//                    orientation : 'landscape',
                    orientation: 'portrait',
                    title: "Leave ",
                    footer: true,
                    exportOptions: {
                        columns: ':not(.noprint)',
                        orthogonal: "Export-pdf"
                    },
                    customize: function (doc) {
                        var rowCount = doc.content[1].table.body.length;
                        for (i = 1; i < rowCount; i++) {

                            /*var val = document.form1.campo.value;
                             if (isNaN(val)){
                             alert(‘Il valore inserito non è numerico’);
                             } else {
                             alert(‘Il valore inserito è numerico’);
                             }*/
                            doc.content[1].table.body[i][0].alignment = 'center';
                            doc.content[1].table.body[i][1].alignment = 'left';
                            doc.content[1].table.body[i][2].alignment = 'left';
                            doc.content[1].table.body[i][3].alignment = 'left';
                           doc.content[1].table.body[i][4].alignment = 'left';
                           doc.content[1].table.body[i][5].alignment = 'left';
                           doc.content[1].table.body[i][6].alignment = 'left';
                           doc.content[1].table.body[i][7].alignment = 'left';
                           doc.content[1].table.body[i][8].alignment = 'left';
                        }
                        doc.content[1].table.widths = ['10%','10%','10%','10%','10%', '10%', '10%', '15%', '15%'];
//                        doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        doc.content.splice(0, 1);
                        var now = new Date();
                        var jsDate = now.getDate() + '-' + (now.getMonth() + 1) + '-' + now.getFullYear() + ' ' + now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds();
                        var logo = '';
                        {{--var header_title = '';--}}
                            doc.pageMargins = [10, 50, 10, 40];
                        doc.defaultStyle.fontSize = 7;

                        doc.defaultStyle.alignment = 'left';
                        doc.styles.tableHeader.alignment = 'left';
                        doc.styles.tableHeader.fontSize = 10;
                        doc.styles.tableFooter.fontSize = 10;
                        doc['header'] = (function () {
                            return {
                                columns: [
                                    {
                                        alignment: 'left',
                                        italics: true,
                                        text: 'Leave ',
                                        fontSize: 10,
                                        margin: [10, 0]
                                    },
                                    // {
                                    //     //image: logo,
                                    //     alignment: 'center',
                                    //     width: 20,
                                    //     height: 20,
                                    //     {{--image: 'data:image/png;base64,{{$settings->logo_base64}}'--}}

                                    // },

                                    {
                                        alignment: 'right',
                                        fontSize: 10,
                                        text: '{{ config('app.name', 'EISL') }}'
                                    }
                                ],
                                margin: 20
                            };
                        });
                        doc['footer'] = (function (page, pages) {
                            return {
                                columns: [
                                    {
                                        alignment: 'left',
                                        text: ['Print On: ', {text: jsDate.toString()}]
                                    },

                                    {
                                        alignment: 'right',
                                        text: ['Pages ', {text: page.toString()}, ' of ', {text: pages.toString()}]
                                    }
                                ],
                                margin: 20
                            };
                        });
                        var objLayout = {};
                        objLayout['hLineWidth'] = function (i) {
                            return .5;
                        };
                        objLayout['vLineWidth'] = function (i) {
                            return .5;
                        };
                        objLayout['hLineColor'] = function (i) {
                            return '#aaa';
                        };
                        objLayout['vLineColor'] = function (i) {
                            return '#aaa';
                        };
                        objLayout['paddingLeft'] = function (i) {
                            return 4;
                        };
                        objLayout['paddingRight'] = function (i) {
                            return 4;
                        };
                        doc.content[0].layout = objLayout;
                    }
                },
                {
                    extend: 'print',
                    footer: true,
                    messageTop: 'Leave  ',
                    messageBottom: '{{'Printed On: '.\Carbon\Carbon::now()->format(' D, d-M-Y, h:ia')}}',
                    exportOptions: {
                        columns: ':not(.noprint)',
                        orthogonal: "Export-pdf"
                    },
                    customize: function (win) {
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');
                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }
            ]

        });


</script>


@endpush

