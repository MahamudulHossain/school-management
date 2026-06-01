@extends('layouts.al4_main')
@section('transport_mo','menu-open')
@section('transport','active')
@section('manage_transport_registration','active')
@section('title','Manage Transport Registration')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Manage Transport Registration</a>
    </li>
@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('supporting/dataTables/bs4/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('supporting/dataTables/fixedHeader.dataTables.min.css') }}">
@endpush
@section('maincontent')
    <div class="row justify-content-center ">
        <div class="col-md-12">
            <div class="card card-success card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                               href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                               aria-selected="true">Active Registration</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-unpaid-tab" data-toggle="pill"
                               href="#custom-tabs-one-unpaid" role="tab" aria-controls="custom-tabs-one-unpaid"
                               aria-selected="false">Inactive Registration</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('transport-registration/create') }}" class="nav-link">+ Register Transport</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">

                        <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                            <table class="table dataTables table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Student Name</th>
                                        <th>Personnel ID</th>
                                        <th>Class, Section & Roll</th>
                                        <th>Transport Info</th>
                                        <th class="noprint">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $index=0;
                                    @endphp
                                    @foreach($active_tranReg as $actReg)
                                        <tr>
                                            <td>{{ ++$index }}</td>
                                            <td>{{ $actReg->user->student->first_name.' '.$actReg->user->student->middle_name.' '.$actReg->user->student->last_name  }}</td>
                                            <td>{{ $actReg->user->personnel_id }}</td>
                                            <td>
                                                {{ $actReg->user->student_academic_histories->last()->student_class->class_name }} <br>
                                                {{ $actReg->user->student_academic_histories->last()->student_section->section_name }}, {{ $actReg->user->student_academic_histories->last()->roll }}
                                            </td>
                                            <td>{{ $actReg->transport->title }}, {{ $actReg->transport->fare }}</td>
                                            <td>
                                                @can('TransportRegistration')
                                                    <a href="{{ url('transport-registration/' . $actReg->id . '/edit') }}" class="btn btn-info btn-sm" title="Edit" id="editTransportRegistration"><span class="far fa-edit" aria-hidden="true"></span></a>
                                                    <form method="POST" action="{{ url('transport-registration/' . $actReg->id) }}" style="display:inline">
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


                        <div class="tab-pane fade" id="custom-tabs-one-unpaid" role="tabpanel" aria-labelledby="custom-tabs-one-unpaid-tab">
                            <table class="table dataTables table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Student Name</th>
                                        <th>Personnel ID</th>
                                        <th>Class, Section & Roll</th>
                                        <th>Transport Info</th>
                                        <th class="noprint">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $index=0;
                                    @endphp
                                    @foreach($inActive_tranReg as $inActReg)
                                        <tr>
                                            <td>{{ ++$index }}</td>
                                            <td>{{ $inActReg->user->student->first_name.' '.$inActReg->user->student->middle_name.' '.$inActReg->user->student->last_name  }}</td>
                                            <td>{{ $inActReg->user->personnel_id }}</td>
                                            <td>
                                                {{ $inActReg->user->student_academic_histories->last()->student_class->class_name }} <br>
                                                {{ $inActReg->user->student_academic_histories->last()->student_section->section_name }}, {{ $inActReg->user->student_academic_histories->last()->roll }}
                                            </td>
                                            <td>{{ $inActReg->transport->title }}, {{ $inActReg->transport->fare }}</td>
                                            <td>
                                                @can('TransportRegistration')
                                                    <a href="{{ url('transport-registration/' . $inActReg->id . '/edit') }}" class="btn btn-info btn-sm" title="Edit" id="editTransportRegistration"><span class="far fa-edit" aria-hidden="true"></span></a>
                                                    <form method="POST" action="{{ url('transport-registration/' . $inActReg->id) }}" style="display:inline">
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
        </div>
    </div>

    {{-- Modal To Register Transport --}}
    <div class="modal fade" id="registerTransportModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <h5 class="modal-title" id="registerTransportModalLabel">Register Transport</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="saveForm">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="personnelId">Personnel ID</label>
                                <input type="text" name="personnel_id" id="personnelId" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <input type="text" name="first_name" id="firstName" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="middleName">Middle Name</label>
                                <input type="text" name="middle_name" id="middleName" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name</label>
                                <input type="text" name="last_name" id="lastName" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="transportId">Transport</label>
                                <select name="transport_id" id="transportId" class="form-control" required>
                                    <option value="" selected disabled>Select transport</option>
                                    @foreach ($transport_info as $id=>$trInfo)
                                        <option value="{{ $id }}">{{ $trInfo }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="" selected disabled>Select status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                </select>
                            </div>

                        </div>

                        <div class="mt-2 d-flex justify-content-end">
                            <button type="submit" class="btn btn-success float-right" id="saveButton"><i
                                        class="fa fa-save"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('js')
<script src="{{ asset('supporting/dataTables/bs4/datatables.min.js')}}"></script>
<script src="{{ asset('supporting/dataTables/dataTables.fixedHeader.min.js')}}"></script>

<script>
    $(document).on('click', '#editTransportRegistration', function(event) {
        event.preventDefault();
        var url = $(this).attr('href');

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#personnelId').val(data.personnel_id);
                $('#firstName').val(data.first_name);
                $('#middleName').val(data.middle_name);
                $('#lastName').val(data.last_name);
                $('#transportId').val(data.transport_id);
                $('#status').val(data.status);
                $('#registerTransportModal').modal('show');
                $('#saveForm').attr('action', siteURL +'/transport-registration/' + data.id);
                $('#saveForm').append('<input type="hidden" name="_method" value="PUT">');
            },
            error: function(xhr, status, error) {
                alert('An error occurred while fetching the data.');
            }
        });
    });

    $(document).on('hidden.bs.modal', '#registerTransportModal', function () {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    });
</script>

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
                {targets: [0, 1, 2, 3, 4], className: 'text-center'},
            ],

            buttons: [
                {extend: 'copy'},
                {extend: 'csv'},
                {
                    extend: 'excel', title: '{{ config('app.name', 'EISL') }}',
                    messageTop: ' Transport Registration'
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
                    filename: 'Transport Registration',
                    extension: '.pdf',
                    orientation: 'portrait',
                    title: "Transport Registration",
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
                        }
                        doc.content[1].table.widths = ['5%', '25%', '25%', '25%', '20%'];
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
                                        text: 'Section ',
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
                    messageTop: 'Transport Registration',
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

