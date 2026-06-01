@extends('layouts.al4_main')
@section('accounting_mo','menu-open')
@section('accounting','active')
@section('manage_assign_sFee','active')
@section('title','Manage Assign fee')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Manage Assign fee</a>
    </li>
@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('supporting/dataTables/bs4/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('supporting/dataTables/fixedHeader.dataTables.min.css') }}">
@endpush
@section('maincontent')
<meta name="_token" content="{{ csrf_token() }}"/>
    <div class="row justify-content-center ">
        <div class="col-md-12">
            <div class="card card-success card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                               href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                               aria-selected="true">Assigned Fees List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-unpaid-tab" data-toggle="pill"
                               href="#custom-tabs-one-unpaid" role="tab" aria-controls="custom-tabs-one-unpaid"
                               aria-selected="false">Unpaid</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-paid-tab" data-toggle="pill"
                               href="#custom-tabs-one-paid" role="tab" aria-controls="custom-tabs-one-paid"
                               aria-selected="false">Paid</a>
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
                                        <th>Fee title</th>
                                        <th>Amount</th>
                                        <th>Paid Amount</th>
                                        <th>Status</th>
                                        <th>Due Date</th>
                                        <th class="noprint">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $index=0;
                                    @endphp
                                    @foreach($accounting_sinvoice as $fee)
                                        <tr>
                                            <td>{{ ++$index }}</td>
                                            <td>{{ $fee->user->student->first_name.' '.$fee->user->student->middle_name.' '.$fee->user->student->last_name  }}</td>
                                            {{--<td>{{ $fee->accounting_sfee->id}}</td>--}}
                                            <td>{{ $fee->accounting_sfee->fee_name }}</td>
                                            <td>{{ $fee->fee_amount }}</td> {{--from invoice table--}}
                                            <td>{{ $fee->collect_amount+$fee->fine_amount-$fee->discount_amount }}</td> {{--from invoice table--}}

                                            <td>
                                                @if($fee->is_status==0)
                                                    <span class="badge text-bg-warning">Unpaid</span>
                                                @else
                                                    <span class="badge text-bg-success">Paid</span>
                                                @endif
                                            </td>
                                            <td>{{ Carbon\Carbon::parse($fee->due_date)->format('d-M-Y') }}</td>
                                            <td>
                                                @can('DeleteAssignSfees')
                                                    <form method="POST" action="{{ url('delete-assign-fees/' . $fee->id) }}" style="display:inline">
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
                                        <th>Fee title</th>
                                        <th>Amount</th>
                                        <th>Paid Amount</th>
                                        <th>Status</th>
                                        <th>Due Date</th>
                                        <th class="noprint">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $index=0;
                                    @endphp
                                    @foreach($student_unpaid as $fee)
                                        <tr>
                                            <td>{{ ++$index }}</td>
                                            <td>{{ $fee->user->student->first_name.' '.$fee->user->student->middle_name.' '.$fee->user->student->last_name  }}</td>
                                            {{--<td>{{ $fee->accounting_sfee->id}}</td>--}}
                                            <td>{{ $fee->accounting_sfee->fee_name }}</td>
                                            <td>{{ $fee->fee_amount }}</td> {{--from invoice table--}}
                                            <td>{{ $fee->collect_amount+$fee->fine_amount-$fee->discount_amount }}</td> {{--from invoice table--}}

                                            <td>
                                                @if($fee->is_status==0)
                                                    <span class="badge text-bg-warning">Unpaid</span>
                                                @else
                                                    <span class="badge text-bg-success">Paid</span>
                                                @endif
                                            </td>
                                            <td>{{ Carbon\Carbon::parse($fee->due_date)->format('d-M-Y') }}</td>
                                            <td>
                                                @can('EditAssignSfees')
                                                <a href="{{ url('assign-fees/'.$fee->id.'/edit') }}" class="btn btn-sm btn-info">TakeFee</a>
                                                @endcan
                                                @can('DeleteAssignSfees')
                                                    <form method="POST" action="{{ url('delete-assign-fees/' . $fee->id) }}" style="display:inline">
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

                        <div class="tab-pane fade" id="custom-tabs-one-paid" role="tabpanel" aria-labelledby="custom-tabs-one-paid-tab">
                            <table class="table dataTables table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Student Name</th>
                                        <th>Fee title</th>
                                        <th>Amount</th>
                                        <th>Paid Amount</th>
                                        <th>Status</th>
                                        <th>Collect Date</th>
                                        <th class="noprint">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $index=0;
                                    @endphp
                                    @foreach($student_paid as $fee)
                                        <tr>
                                            <td>{{ ++$index }}</td>
                                            <td>{{ $fee->user->student->first_name.' '.$fee->user->student->middle_name.' '.$fee->user->student->last_name  }}</td>
                                            {{--<td>{{ $fee->accounting_sfee->id}}</td>--}}
                                            <td>{{ $fee->accounting_sfee->fee_name }}</td>
                                            <td>{{ $fee->fee_amount }}</td> {{--from invoice table--}}
                                            <td>{{ $fee->collect_amount+$fee->fine_amount-$fee->discount_amount }}</td> {{--from invoice table--}}

                                            <td>
                                                @if($fee->is_status==0)
                                                    <span class="badge text-bg-warning">Unpaid</span>
                                                @else
                                                    <span class="badge text-bg-success">Paid</span>
                                                @endif
                                            </td>
                                            <td>{{ Carbon\Carbon::parse($fee->collect_date)->format('d-M-Y') }}</td>
                                            <td>
                                                @can('EditAssignSfees')
                                                <a href="{{ url('assign-fees/'.$fee->id.'/edit') }}" class="btn btn-sm btn-primary">Edit</a>
                                                @endcan
                                                @can('DeleteAssignSfees')
                                                    <form method="POST" action="{{ url('delete-assign-fees/' . $fee->id) }}" style="display:inline">
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
                {targets: [0, 1, 2 ], className: 'text-left'},
                {targets: [3,4 ], className: 'text-center'},
            ],

            buttons: [
                {extend: 'copy'},
                {extend: 'csv'},
                {
                    extend: 'excel', title: '{{ config('app.name', 'EIS') }}',
                    messageTop: ' Assigned Fees List '
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
                    filename: 'Assigned Fees List ',
                    extension: '.pdf',
                    // orientation : 'landscape',
                    orientation: 'portrait',
                    title: "Assigned Fees List ",
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
                            doc.content[1].table.body[i][3].alignment = 'right';
                            doc.content[1].table.body[i][4].alignment = 'right';
                            doc.content[1].table.body[i][5].alignment = 'left';
                            doc.content[1].table.body[i][6].alignment = 'left';
                        }
                        doc.content[1].table.widths = ['10%', '15%', '15%', '15%', '15%', '15%', '15%'];
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
                                        text: 'Assigned Fees List ',
                                        fontSize: 10,
                                        margin: [10, 0]
                                    },
                                    {
                                        alignment: 'right',
                                        fontSize: 10,
                                        text: '{{ config('app.name', 'EIS') }}'
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
                    messageTop: 'Subject  ',
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
