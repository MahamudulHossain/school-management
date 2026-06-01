<div class="tab-pane" id="routine">

    <div class="card-body">
        @php
            $data = routine($stu_aca_his[0]->school_class_id,$stu_aca_his[0]->school_section_id,$stu_aca_his[0]->academic_year_id);
            // dd($data);
        @endphp

        @if(count($data['routines']))
        <div class=" align-items-center mb-4">
            <div>
                <h4>Class Routine</h4>
                <p class="mb-1">
                    <strong>Class:</strong> {{ $data['school_class']->class_name }} |
                    <strong>Section:</strong> {{ $data['school_section']->section_name }} |
                    <strong>Shift:</strong> {{ $data['routines']->first()->shift == '0' ? 'Morning' : 'Day' }} |
                    <strong>Year:</strong> {{ $data['year']->title }}
                </p>
            </div>

            <div class="table-responsive shadow-sm">
                <table class="table table-bordered text-center mb-0">
                    <thead class="table-primary align-middle">
                        <tr>
                            <th style="min-width:150px;">Day \ Period</th>
                            @foreach($data['periods'] as $p)
                                <th>
                                    {{ $data['shiftArr'][$p]['title'] }} <br>
                                    ({{ $data['shiftArr'][$p]['start_time'] }} - {{ $data['shiftArr'][$p]['end_time'] }})
                                </th>
                                @if ($p == $data['tiffin_starts_after'])
                                    <th>
                                        {{ $data['shiftArr'][0]['title'] }} <br>
                                        ({{ $data['shiftArr'][0]['start_time'] }} - {{ $data['shiftArr'][0]['end_time'] }})
                                    </th>
                                @endif
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['daysOfWeek'] as $day)
                            <tr>
                                <th class="text-start bg-light">{{ $day }}</th>

                                @foreach($data['periods'] as $p)
                                    @php $cell = $data['matrix'][$day][$p] ?? null; @endphp
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
                                    @if ($p == $data['tiffin_starts_after'])
                                        <td>{{ $data['shiftArr'][0]['title'] }}</td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
            <div class="alert alert-danger">No routine found</div>
        @endif

    </div>

</div>
