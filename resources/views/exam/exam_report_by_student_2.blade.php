@extends('layouts.al4_main')
@section('exam_mo','menu-open')
@section('exam','active')
@section('manage_exam_report','active')
@section('title','Exam Report')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Exam Report</a>
    </li>
@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('supporting/dataTables/bs4/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('supporting/dataTables/fixedHeader.dataTables.min.css') }}">
<style>
    .table th, .table td {
    vertical-align: middle !important;
}
tfoot th {
    font-weight: 600;
    font-size: 0.95rem;
}

@media print {
    .btn {
        display: none;
    }
}
</style>
<style id="print-override">
@media print {
  .card *,
  .card-header,
  .card-title,
  .card-body h1, .card-body h2, .card-body h3,
  .card-body h4, .card-body h5, .card-body h6,
  .text-dark {
    color: #000 !important;
    -webkit-print-color-adjust: exact !important;
    print-color-adjust: exact !important;
  }
}
</style>
@endpush
@section('maincontent')
    <div class="container-fluid">
        <div class="card-header">
            <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#clsRpt" data-toggle="tab">Semester Details</a>
                </li>
                <li class="nav-item"><a class="nav-link" href="#stuRpt" data-toggle="tab">Result Summary</a>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="clsRpt">
                <div id="print_this0">
                    @foreach($resultData as $term)
                        <div style="margin-bottom:15px">
                            <div class="card shadow-sm mb-4 result-card" id="term-{{ $term['term_id'] }}">
                                <div class="card-header bg-primary text-white align-items-center">
                                    <div class="d-flex justify-content-center">
                                        <h5 class="mb-0">{{ $term['term_name'] }} -  {{ $academic_year->title }}</h5>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="mb-0">Name: {{ $stu_name->first_name.' '.$stu_name->middle_name.' '.$stu_name->last_name }}</span>
                                        <span class="mb-0">Class: {{ $school_class->class_name }}</span>
                                        <span class="mb-0">Section: {{ $school_section->section_name }}</span>
                                        <span class="mb-0">Roll: {{ $term['roll'] }}</span>
                                    </div>
                                </div>

                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped mb-0">
                                            <thead class="bg-light text-center align-middle">
                                                <tr>
                                                    <th rowspan="2">Subject</th>
                                                    <th colspan="{{ count($term['criteria_headers']) }}">Added Marks</th>
                                                    <th rowspan="2">Total</th>
                                                    <th rowspan="2">Highest</th>
                                                    <th rowspan="2">Letter Grade</th>
                                                    <th rowspan="2">Grade Point</th>
                                                </tr>
                                                <tr>
                                                    @foreach($term['criteria_headers'] as $criteria)
                                                        <th>{{ $criteria }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach($term['subjects'] as $subject)
                                                    <tr class="text-center">
                                                        <td class="text-start fw-semibold">{{ $subject['subject_name'] }}</td>

                                                        {{-- Dynamic criteria marks --}}
                                                        @foreach($term['criteria_headers'] as $criteria)
                                                            <td>{{ $subject['criteria_marks'][$criteria] ?? '-' }}</td>
                                                        @endforeach

                                                        <td class="fw-semibold">{{ $subject['total'] }}</td>
                                                        <td>{{ $subject['highest'] }}</td>
                                                        <td>{{ $subject['letter_grade'] }}</td>
                                                        <td>{{ $subject['grade_point'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>

                                            {{-- Footer for criteria totals and summary --}}
                                            <tfoot class="bg-success text-white text-center">
                                                <tr>
                                                    <th>Total</th>
                                                    @foreach($term['criteria_headers'] as $criteria)
                                                        <th>{{ $term['criteria_totals'][$criteria] ?? 0 }}</th>
                                                    @endforeach
                                                    <th>{{ $term['grand_total'] }}</th>
                                                    <th colspan="2">GPA</th>
                                                    <th>{{ $term['gpa'] }}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-8">
                                    <div class="card-header bg-info text-white p-2">
                                        <h4 class="mb-0">📊 {{ $term['term_name'] }} Result Summary</h4>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table  mb-0 ">
                                            <tr>
                                                <td class="text-start">Total Mark</td>
                                                <td class="text-end">{{ $term['total_mark'] }}</td>
                                                <td class="text-start">Total Obtained</td>
                                                <td class="text-end">{{ $term['grand_total'] }}</td>
                                                <td class="text-start">Percentage</td>
                                                <td class="text-end">{{ round(($term['grand_total']*100) / $term['total_mark'] , 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-start">Total GP</td>
                                                <td class="text-end">{{ $term['grand_points'] }}</td>
                                                <td class="text-start">GPA</td>
                                                <td class="text-end">{{ $term['gpa'] }}</td>
                                                <td class="text-start">Letter Grade</td>
                                                <td class="text-end"> {{ $term['letter_grade'] }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <a type="button" id="pbutton0" class="btn btn-warning pull-right btn-sm"><i
                        class="fa fa-print"> Print</i></a>
                    <button class="btn btn-info btn-sm" id="pdfBtn" onclick="downloadPDF()" style="margin-left:5px">
                        <i class="fas fa-file-pdf"></i> Download PDF</button>
                </div>
            </div>
            <div class="tab-pane" id="stuRpt">
                @php
                    $terms = collect($resultSummary)->flatten(1)->pluck('term_name')->unique();
                @endphp

                <div id="print_this1">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Student Result Summary</h5>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-bordered table-striped text-center align-middle mb-0">
                            <thead class="table-primary">
                                <tr>
                                <th rowspan="2">Subject</th>
                                <th rowspan="2">Full Mark</th>
                                @foreach ($terms as $term)
                                    <th colspan="3" class="text-center bg-gradient-light">
                                    {{ $term }}
                                    </th>
                                @endforeach
                                </tr>
                                <tr>
                                @foreach ($terms as $term)
                                    <th>Obtained Marks</th>
                                    <th>Letter Grade</th>
                                    <th>Grade Point</th>
                                @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($resultSummary as $subject => $semesters)
                                <tr>
                                    <td>{{ $subject }}</td>
                                    <td>100</td> {{-- You can replace with dynamic full marks if available --}}
                                    @foreach ($terms as $term)
                                    @php
                                        $termData = collect($semesters)->firstWhere('term_name', $term);
                                    @endphp
                                    @if ($termData)
                                        <td>{{ $termData['total'] }}</td>
                                        <td>{{ $termData['letter_grade'] }}</td>
                                        <td>{{ $termData['grade_point'] }}</td>
                                    @else
                                        <td colspan="3" class="bg-light text-muted">—</td>
                                    @endif
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-secondary">
                                <tr>
                                <th colspan="2">Total</th>
                                @foreach ($terms as $term)
                                    @php
                                    $termTotals = collect($resultSummary)->map(function ($subjects) use ($term) {
                                        $termData = collect($subjects)->firstWhere('term_name', $term);
                                        return $termData['total'] ?? 0;
                                    })->sum();
                                    @endphp
                                    <th>{{ $termTotals }}</th>
                                    <th></th>
                                    <th></th>
                                @endforeach
                                </tr>
                            </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Term-wise Exam Summary</h5>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-bordered text-center align-middle mb-0">
                            <thead style="background-color: #e5b4ec;">
                                <tr>
                                <th>Exam</th>
                                <th>Full Marks</th>
                                <th>Obtained Marks</th>
                                <th>Average Marks</th>
                                <th>G.P.A</th>
                                <th>Letter Grade</th>
                                <th>Total Students</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($resultSummary_tbl2 as $term => $values)
                                <tr>
                                    <td class="fw-bold">{{ $term }}</td>
                                    <td>{{ $values['full_marks'] }}</td>
                                    <td>{{ $values['obtained_marks'] }}</td>
                                    <td>{{ number_format($values['obtained_marks'] / ($values['full_marks'] / 100), 2) }}%</td>
                                    <td>{{ $values['gpa'] }}</td>
                                    <td>{{ $values['letter_grade'] }}</td>
                                    <td>{{ $total_students }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end mt-2">
                    <a type="button" id="pbutton1" class="btn btn-warning pull-right btn-sm"><i
                        class="fa fa-print"> Print</i></a>
                    <button class="btn btn-info btn-sm" id="pdfBtn1" onclick="downloadPDF1()" style="margin-left:5px">
                        <i class="fas fa-file-pdf"></i> Download PDF</button>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('js')
<script src="{{ asset('supporting/dataTables/bs4/datatables.min.js')}}"></script>
<script src="{{ asset('supporting/dataTables/dataTables.fixedHeader.min.js')}}"></script>
<script src="{!! asset('supporting/printthis.js')!!}" type="text/javascript"></script>
<script src="{{ asset('supporting/pdfmake/jsPdf.min.js') }}"></script>
<script src="{{ asset('supporting/pdfmake/html2canvas.min.js') }}"></script>

<script>
    $('#pbutton0').on('click', function () {
        $("#print_this0").printThis({
            debug: false,
            importCSS: true,
            importStyle: true,
            loadCSS: '#print-override',
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
    $('#pbutton1').on('click', function () {
        $("#print_this1").printThis({
            debug: false,
            importCSS: true,
            importStyle: true,
            loadCSS: '#print-override',
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
        const btn = document.getElementById('pdfBtn');
        btn.disabled = true;
        btn.textContent = 'Downloading…';

        try {
            const { jsPDF } = window.jspdf;
            const element   = document.getElementById('print_this0');
            const dpi       = 300;
            const scale     = dpi / 96;
            const canvas    = await html2canvas(element, { scale, useCORS: true });
            const imgData   = canvas.toDataURL('image/png');

            const pdf       = new jsPDF('p', 'mm', 'a4');
            const pageWidth = pdf.internal.pageSize.getWidth();
            const pageHeight= pdf.internal.pageSize.getHeight();
            const margin    = 15;
            const usableW   = pageWidth  - 2 * margin;
            const usableH   = pageHeight - 2 * margin;

            const imgWidth  = usableW;
            const imgHeight = (canvas.height * imgWidth) / canvas.width;
            let heightLeft  = imgHeight;
            let topOffset   = margin;

            pdf.addImage(imgData, 'PNG', margin, topOffset, imgWidth, imgHeight, '', 'FAST');
            heightLeft -= usableH;

            while (heightLeft > 0) {
            topOffset = heightLeft - imgHeight + margin;
            pdf.addPage();
            pdf.addImage(imgData, 'PNG', margin, topOffset, imgWidth, imgHeight, '', 'FAST');
            heightLeft -= usableH;
            }

            pdf.save('Exam report.pdf');
        } finally {
            btn.disabled = false;
            btn.textContent = 'Download PDF';
        }
    }
</script>
<script>
    async function downloadPDF1() {
        const btn = document.getElementById('pdfBtn1');
        btn.disabled = true;
        btn.textContent = 'Downloading…';

        try {
            const { jsPDF } = window.jspdf;
            const element   = document.getElementById('print_this1');
            const dpi       = 300;
            const scale     = dpi / 96;
            const canvas    = await html2canvas(element, { scale, useCORS: true });
            const imgData   = canvas.toDataURL('image/png');

            const pdf       = new jsPDF('p', 'mm', 'a4');
            const pageWidth = pdf.internal.pageSize.getWidth();
            const pageHeight= pdf.internal.pageSize.getHeight();
            const margin    = 15;
            const usableW   = pageWidth  - 2 * margin;
            const usableH   = pageHeight - 2 * margin;

            const imgWidth  = usableW;
            const imgHeight = (canvas.height * imgWidth) / canvas.width;
            let heightLeft  = imgHeight;
            let topOffset   = margin;

            pdf.addImage(imgData, 'PNG', margin, topOffset, imgWidth, imgHeight, '', 'FAST');
            heightLeft -= usableH;

            while (heightLeft > 0) {
            topOffset = heightLeft - imgHeight + margin;
            pdf.addPage();
            pdf.addImage(imgData, 'PNG', margin, topOffset, imgWidth, imgHeight, '', 'FAST');
            heightLeft -= usableH;
            }

            pdf.save('Result Summary.pdf');
        } finally {
            btn.disabled = false;
            btn.textContent = 'Download PDF';
        }
    }
</script>
@endpush
