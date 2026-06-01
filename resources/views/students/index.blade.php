@extends('layouts.al4_main')
@section('student_mo','menu-open')
@section('student','active')
@section('manage_student','active')
@section('title','Manage Student')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Manage Student</a>
    </li>
@endsection
@push('css')
<style>
    .avatar {
    border-radius: 50% !important;
}
</style>
<link rel="stylesheet" href="{{ asset('supporting/dataTables/bs4/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('supporting/dataTables/fixedHeader.dataTables.min.css') }}">

@endpush
@section('maincontent')
    <div class="card card-success card-tabs">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                       href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                       aria-selected="true">Student</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-one-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel"
                     aria-labelledby="custom-tabs-one-home-tab">
                    <table class="table dataTables table-striped table-bordered table-hover">
                        <thead>
                    <tr>
                        <th>No</th>
                        <th>Picture</th>
                        <th>Email</th>
                        <th>Full Name & Personnel ID</th>
                        <th>Class <br/> Section</th>
                        <th>Roll</th>
                        <th>User Type <br/>Roles</th>
                        <th width="280px" class="noprint">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $key => $student)

                        <tr>
                            <td>
                                {{$key+1}}
                            </td>
                            <td>
                                @if($student->imageprofile->image=='default_image.png' && $student->profile->gender=='Male')
                                    <img src="{!! asset( 'storage/images/avatar_male'.'.jpg'. '?'. 'time='. time()) !!}"
                                         class="profile-user-img img-fluid img-circle" style="-webkit-user-select:none; width: 40px; height: 40px; display:block; margin:auto;">
                                @elseif($student->imageprofile->image=='default_image.png' && $student->profile->gender=='Female')
                                    <img
                                            src="{!! asset( 'storage/images/avatar_female'.'.jpg'. '?'. 'time='. time()) !!}"
                                            class="profile-user-img img-fluid img-circle" style="-webkit-user-select:none; width: 40px; height: 40px; display:block; margin:auto;">
                                @else
                                    <img
                                            src="{!! asset( 'storage/image_profile/'. $student->imageprofile->image. '?'. 'time='. time()) !!}"
                                            class="profile-user-img img-fluid img-circle" alt="User Image" style="-webkit-user-select:none; width: 40px; height: 40px; display:block; margin:auto;">
                                @endif
                            </td>
                            <td>{{ $student->email }}</td>
                            <td>
                                {{ $student->student->first_name.' '.$student->student->middle_name.' '.$student->student->last_name }}
                                <br>
                                {{ $student->personnel_id }}
                            </td>
                            <td>{{ $student->student_academic_histories->last()->student_class->class_name }} <br/>
                                {{ $student->student_academic_histories->last()->student_section->section_name }}
                            </td>
                            <td>{{ $student->student_academic_histories->last()->roll }}</td>
                            <td>{{ $student->user_type->title }} <br/>
                                @if(!empty($student->roles))
                                    @foreach($student->roles as $v)
                                        <span class="badge text-bg-primary">{{ $v->title }}</span>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('user/' . $student->id) }}" class="btn btn-success btn-sm" title="View"><span class="far fa-eye" aria-hidden="true"></span></a>
                                @can('StudentEdit')
                                    <a href="{{ url('user/' . $student->id . '/edit') }}" class="btn btn-info btn-sm" title="Edit"><span class="far fa-edit" aria-hidden="true"></span></a>
                                @endcan
                                @can('StudentDelete')
                                    <form method="POST" action="{{ url('user/' . $student->id) }}" style="display:inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="btn btn-danger btn-sm"
                                            title="Delete"
                                            onclick="return confirm('Confirm delete?')">
                                            <span class="far fa-trash-alt" aria-hidden="true" title="Delete"></span>
                                        </button>
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
                </div>
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
            'dom': "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            columnDefs: [
                {targets: [0, 1, 2,3,4,5,6,7], className: 'text-center'},
            ],

            buttons: [
                {extend: 'copy'},
                {extend: 'csv'},
                {
                    extend: 'excel', title: '{{ config('app.name', 'EISL') }}',
                    messageTop: ' Student   '
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
                    filename: 'Student',
                    extension: '.pdf',
                    orientation: 'portrait',
                    title: "Student",
                    footer: true,
                    exportOptions: {
                        columns: ':not(.noprint)',
                        orthogonal: "Export-pdf"
                    },
                    customize: function (doc) {
                        var rowCount = doc.content[1].table.body.length;
                        for (i = 1; i < rowCount; i++) {
                            doc.content[1].table.body[i][0].alignment = 'center';
                            doc.content[1].table.body[i][1].alignment = 'left';
                            doc.content[1].table.body[i][2].alignment = 'left';
                            doc.content[1].table.body[i][3].alignment = 'left';
                            doc.content[1].table.body[i][4].alignment = 'left';
                            doc.content[1].table.body[i][5].alignment = 'left';
                            doc.content[1].table.body[i][6].alignment = 'left';
                        }
                        doc.content[1].table.widths = ['10%', '20%', '20%','20%', '10%', '10%', '10%'];
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
                                        text: 'Teacher ',
                                        fontSize: 10,
                                        margin: [10, 0]
                                    },
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
                    messageTop: 'Student',
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

</script>


@endpush

