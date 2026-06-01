@extends('layouts.al4_main')
@section('user_mo','menu-open')
@section('user','active')
@section('manage_user','active')
@section('title','Manage User')
@push('css')
<link rel="stylesheet" href="{{ asset('supporting/dataTables/bs4/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('supporting/dataTables/fixedHeader.dataTables.min.css') }}">
@endpush
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('user')}}" class="nav-link">User</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Manage User</a>
    </li>
@endsection

@section('maincontent')
    <div class="card card-success card-tabs">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                       href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                       aria-selected="true">Users </a>
                </li>
                <li class="nav-item">
                    @can('UserAccess')
                        <a href="{{ url('user/create') }}" class="nav-link">
                            Add User
                        </a>
                    @endcan
                </li>

            </ul>
        </div>
        <div class="card-body">
            <table class="table dataTables table-striped table-bordered table-hover">
                <thead>
                <tr style="background-color: #dff0d8">
                    <th>No</th>
                    <th>Name</th>
                    <th>email</th>
                    <th>Cell No</th>
                    <th>User Type</th>
                    <th width="280px" class="noprint">Action</th>
                </tr>
                </thead>
                @foreach ($users as $key => $user)
                    <tr>
                        <td>{{ $key+1 }}</td>

                        <td>
                            @if($user->user_type->title == 'Teacher')
                                {{ $user->teacher->first_name.' '.$user->teacher->middle_name.' '.$user->teacher->last_name }}
                            @elseif($user->user_type->title == 'Student')
                                {{ $user->student->first_name.' '.$user->student->middle_name.' '.$user->student->last_name }}
                            @elseif($user->user_type->title == 'Employee')
                                {{ $user->employee->first_name.' '.$user->employee->middle_name.' '.$user->employee->last_name }}
                            @else
                                {{$user->name}}
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->cell_phone}}</td>
                        <td>{{ $user->user_type->title ?? '' }}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-warning">Action</button>
                                <button type="button"
                                        class="btn btn-warning dropdown-toggle dropdown-hover dropdown-icon main_action"
                                        data-toggle="dropdown"
                                        aria-expanded="false" name="main_action" value="{{$user->id}}">
                                </button>
                                <ul class="dropdown-menu pull-right" role="menu" id="sub_action">

                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
            {{--</div>--}}
        </div>
    </div>
@endsection
@push('js')
<script src="{{ asset('supporting/dataTables/bs4/datatables.min.js')}}"></script>
<script src="{{ asset('supporting/dataTables/dataTables.fixedHeader.min.js')}}"></script>

<script>
    $(document).on('click', '.main_action', function () {

        var $this = $(this);
        var main_action = $(this).val();
        var token = $("input[name='_token']").val();
//            console.log(main_category_id);
        $.ajax({
            url: "<?php echo route('select_user_action') ?>",
            method: 'POST',
            data: {main_action: main_action, _token: token},
            success: function (data) {
//                    console.log(data);
                $this.closest('tr').find('#sub_action').html(data.options);
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('.dataTables').DataTable({
            aaSorting: [],
            lengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
            ],
            pageLength: 25,
            responsive: true,
            fixedHeader: true,
            'dom': "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            columnDefs: [
                {targets: [0, 1, 2, 3, 4,5], className: 'text-center'},
            ],

            buttons: [
                {extend: 'copy'},
                {extend: 'csv'},
                {
                    extend: 'excel', title: '{{ config('app.name', 'EISL') }}',
                    messageTop: 'Users List '
                },
                {
                    extend: 'pdfHtml5',

                    className: 'btn  btn-sm btn-table',
                    titleAttr: 'Export to Pdf',
                    text: '<span class="fa fa-file-pdf-o fa-lg"></span><i class="hidden-xs hidden-sm hidden-md"> Pdf</i>',
                    filename: 'Users List ',
                    extension: '.pdf',
                    orientation: 'portrait',
                    title: "Users List ",
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
                        doc.content[1].table.widths = ['10%', '20%', '40%', '15%', '15%'];
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
                                        text: 'Users List ',
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
                    messageTop: 'Users List ',
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
