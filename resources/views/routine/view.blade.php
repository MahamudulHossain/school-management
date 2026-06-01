@extends('layouts.al4_main')
@section('timetable_mo','menu-open')
@section('timetable','active')
@section('view_class_timetable','active')
@section('title','View Weekly Timetable')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">View Weekly Timetable</a>
    </li>
@endsection
@push('css')
<style>
    @media print {
        .btn {
            display: none;
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
                       aria-selected="true">View Weekly Timetable</a>
                </li>
            </ul>
        </div>
        <div class="card-body" id="print_this0">
            <div class="tab-content" id="custom-tabs-one-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel"
                     aria-labelledby="custom-tabs-one-home-tab">
                    <div class=" align-items-center mb-4">
                        <div>
                            <h4>Class Routine</h4>
                            <p class="mb-1">
                                <strong>Class:</strong> {{ $school_class->class_name }} |
                                <strong>Section:</strong> {{ $school_section->section_name }} |
                                <strong>Shift:</strong> {{ $routines->first()->shift == '0' ? 'Morning' : 'Day' }} |
                                <strong>Year:</strong> {{ $year->title }}
                            </p>
                        </div>

                        <div class="table-responsive shadow-sm">
                            <table class="table table-bordered text-center mb-0">
                                <thead class="table-primary align-middle">
                                    <tr>
                                        <th style="min-width:150px;">Day \ Period</th>
                                        @foreach($periods as $p)
                                            <th>
                                                {{ $shiftArr[$p]['title'] }} <br>
                                                ({{ $shiftArr[$p]['start_time'] }} - {{ $shiftArr[$p]['end_time'] }})
                                            </th>
                                            @if ($p == $tiffin_starts_after)
                                                <th>
                                                    {{ $shiftArr[0]['title'] }} <br>
                                                    ({{ $shiftArr[0]['start_time'] }} - {{ $shiftArr[0]['end_time'] }})
                                                </th>
                                            @endif
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($daysOfWeek as $day)
                                        <tr>
                                            <th class="text-start bg-light">{{ $day }}</th>

                                            @foreach($periods as $p)
                                                @php $cell = $matrix[$day][$p] ?? null; @endphp
                                                <td style="vertical-align: middle; width:150px;">
                                                    @if($cell)
                                                        <div class="fw-bold">
                                                            {{ $cell->subject->subject_name ?? '—' }}
                                                        </div>
                                                        <div class="small text-muted">
                                                            @php
                                                                $teacherName = null;
                                                                if(isset($cell->teacher)) {
                                                                    $teacherName = $cell->teacher->first_name .' '. $cell->teacher->last_name ?? null;
                                                                }
                                                            @endphp
                                                            {{ $teacherName ?? 'Teacher N/A' }}
                                                        </div>
                                                    @else
                                                        <div class="text-muted">—</div>
                                                    @endif
                                                </td>
                                                @if ($p == $tiffin_starts_after)
                                                    <td>{{ $shiftArr[0]['title'] }}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-end">
            <a type="button" id="pbutton0" class="btn btn-warning pull-right btn-sm"><i
                class="fa fa-print"> Print</i></a>
            <button class="btn btn-info btn-sm" onclick="downloadPDF()" style="margin-left:5px">
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
        const canvas = await html2canvas(element, { scale: 1.2 });
        const imgData = canvas.toDataURL("image/jpeg",0.6);

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
        pdf.addImage(imgData, "JPEG", 0, position, imgWidth, imgHeight, '', 'FAST');
        heightLeft -= pageHeight;
        // Download
        pdf.save("Class routine.pdf");
    }
</script>
@endpush
