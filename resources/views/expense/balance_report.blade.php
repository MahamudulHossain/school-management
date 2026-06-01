@extends('layouts.al4_main')
@section('accounting_mo','menu-open')
@section('accounting','active')
@section('balance_report','active')
@section('title','Balance Report')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Balance Report</a>
    </li>
@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('supporting/dataTables/bs4/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('supporting/dataTables/fixedHeader.dataTables.min.css') }}">
<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 16px;
        line-height: 1.4;
    }
    .card {
        border: 1px solid #ddd;
        margin: 0;
    }
    .card-header {
        background-color: #f8f9fa;
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }
    .card-body {
        padding: 15px;
    }
    .text-center {
        text-align: center;
    }
    .text-right {
        text-align: right;
    }
    .float-right {
        float: right;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 6px;
        font-size: 16px;
    }
    th {
        background-color: #f2f2f2;
        font-weight: bold;
    }
    .btn {
        display: inline-block;
        padding: 6px 12px;
        margin-bottom: 0;
        font-size: 14px;
        font-weight: 400;
        line-height: 1.42857143;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        cursor: pointer;
        border: 1px solid transparent;
        border-radius: 4px;
    }
    .btn-info {
        color: #fff;
        background-color: #5bc0de;
        border-color: #46b8da;
    }
    .btn-outline-dark {
        color: #343a40;
        background-color: transparent;
        border-color: #343a40;
    }
    .page-break {
        page-break-after: always;
    }
    @media print {
        .btn {
            display: none;
        }
        .pdc_tbl{
            max-width: 40%;
        }
    }
</style>
@endpush
@section('maincontent')
    <div class="card card-success card-tabs">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                       href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                       aria-selected="true">Balance Report From {{ Carbon\Carbon::parse($start_date)->format('d-M-Y').' to '.Carbon\Carbon::parse($end_date)->format('d-M-Y') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('balance-report-daterange') }}">Search</a>
                </li>
            </ul>
        </div>
        <div class="card-body"  id="print_this0">
            <div class="tab-content" id="custom-tabs-one-tabContent">

                <table class="table dataTables table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th >Balance Summary</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th class="col-md-5"  style="text-align:right">Balance:&nbsp;&nbsp;</th>
                        <th class="col-md-1" style="text-align:right">{{$balance}}</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <tr>
                        <td class="col-md-5" style="text-align:right">Balance b/d (brought down):&nbsp;&nbsp;</td>
                        <td class="col-md-1" style="text-align:right">{{$balance_bd}}</td>
                    </tr>
                    <tr>
                        <td class="col-md-5" style="text-align:right">
                            ({{Carbon\Carbon::parse($start_date)->format('d-M-Y').' to '.Carbon\Carbon::parse($end_date)->format('d-M-Y')}})
                            <strong> Total Income :&nbsp;&nbsp;</strong></td>
                        <td class="col-md-1" style="text-align:right">{{$total_income}}</td>
                    </tr>
                        <tr>
                            <td class="col-md-5" style="text-align:right">
                                ({{Carbon\Carbon::parse($start_date)->format('d-M-Y').' to '.Carbon\Carbon::parse($end_date)->format('d-M-Y')}})
                                <strong>Total Expense :&nbsp;&nbsp;</strong></td>
                            <td class="col-md-1" style="text-align:right">{{$total_expense}}</td>
                        </tr>

                    </tbody>
                </table>

                <table class="table dataTables table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="col-md-1">S.No</th><th class="col-md-3"> Income Title </th><th class="col-md-1">Collection Date</th><th class="col-md-1">Amount</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th class="col-md-5" colspan="3" style="text-align:right">Total Income:&nbsp;&nbsp;</th>
                        <th class="col-md-1" style="text-align:right">{{$total_income}}</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @php
                        $x=0;
                    @endphp
                    @foreach($income as $section)
                        <tr>
                            <td>{{ ++$x }}</td>
                            <td>{{ $section->accounting_sfee->fee_name }}</td>
                            <td>{{Carbon\Carbon::parse($section->collect_date)->format('d-M-Y')}}</td>
                            <td style="text-align:right">{{ $section->collect_amount+$section->fine_amount-$section->discount_amount }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <table class="table dataTables table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="col-md-1">S.No</th><th class="col-md-3"> Expense Title </th><th class="col-md-1">Date of Expense</th><th class="col-md-1">Amount</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th class="col-md-5" colspan="3" style="text-align:right">Total Expense:&nbsp;&nbsp;</th>
                        <th class="col-md-1" style="text-align:right">{{$total_expense}}</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @php
                        $y=0;
                    @endphp
                    @foreach($expense as $section)
                        <tr>
                            <td>{{ ++$y }}</td>
                            <td>{{ $section->expense_type->expense_name }}</td>
                            {{--<td>{{ $section->expense_date }}</td>--}}
                            <td>{{Carbon\Carbon::parse($section->expense_date)->format('d-M-Y')}}</td>
                            <td style="text-align:right">{{ $section->expense_amount }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        <div class="card-footer">
        <a type="button" id="pbutton0" class="btn btn-warning pull-right btn-sm"><i
                                class="fa fa-print"> Print</i></a>
        <button class="btn btn-info btn-sm" onclick="downloadPDF()">
            <i class="fas fa-file-pdf"></i> Download PDF</button>
    </div>
    </div>
@endsection

@push('js')
<script src="{!! asset('supporting/printthis.js')!!}" type="text/javascript"></script>
<script src="{{ asset('supporting/pdfmake/jsPdf.min.js') }}"></script>
<script src="{{ asset('supporting/pdfmake/html2canvas.min.js') }}"></script>

<script>
    $('#pbutton0').on('click', function () {
        $("#print_this0").printThis({
            debug: false,
            importCSS: true,
            importStyle: true,
            printContainer: true,
            pageTitle: "",
            removeInline: false,
            printDelay: 333,
            header: null,
            footer: null,
            base: false,
            canvas: false,
            removeScripts: false,
            copyTagClasses: false
        });
    });
</script>

<script>
    async function downloadPDF() {
        const { jsPDF } = window.jspdf;

        // Target the section you want to export
        const element = document.getElementById("print_this0");

        // Convert to canvas
        const canvas = await html2canvas(element, { scale: 2 });
        const imgData = canvas.toDataURL("image/png");

        // Create PDF
        const pdf = new jsPDF("p", "mm", "a4");
        const pageWidth = pdf.internal.pageSize.getWidth();
        const pageHeight = pdf.internal.pageSize.getHeight();

        // Image dimensions
        const imgWidth = pageWidth;
        const imgHeight = (canvas.height * imgWidth) / canvas.width;

        let heightLeft = imgHeight;
        let position = 0;

        // First page
        pdf.addImage(imgData, "PNG", 0, position, imgWidth, imgHeight);
        heightLeft -= pageHeight;

        // Extra pages if needed
        while (heightLeft > 0) {
            position = heightLeft - imgHeight;
            pdf.addPage();
            pdf.addImage(imgData, "PNG", 0, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;
        }

        // Download
        pdf.save("Balance Report.pdf");
    }
</script>
@endpush

