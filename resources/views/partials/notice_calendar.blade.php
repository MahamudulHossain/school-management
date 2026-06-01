@push('css')
    <style>
.card-body-scroll {
    overflow-y: auto; /* Adds a vertical scrollbar when content exceeds max-height */
}
</style>
@endpush
<div class="row">
    <div class="col-md-6 col-sm-6">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-bullhorn text-primary"></i>
                    <span class="font-weight-bold text-uppercase">Notice Board</span>
                </h3>
            </div>
            {{--
                Key Change: Added custom CSS class 'card-body-scroll' to apply height constraint.
                The 'p-0' class is kept to remove padding around the table.
            --}}
            <div class="card-body p-0 card-body-scroll">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover mb-0">
                        <tbody>
                        @foreach($notice as $stu)
                            <tr>
                                <td>
                                    <a href="{{ asset('storage/pdf/' . $stu->details) }}" title="Details View" style="text-decoration: none">
                                        <span class="font-weight-bold text-primary text-uppercase"><b>{{ $stu->title }}</b></span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6">
        <div class="card card-outline card-info" id="calendar-card"> {{-- Added ID for JavaScript reference --}}
            <div class="card-header border-bottom-0">
                {{-- Calendar Title (Optional) --}}
            </div>
            <div class="card-body" id="calendar-body"> {{-- Added ID for JavaScript reference --}}
                {{-- Calendar --}}
                <div id="calendar"></div>
            </div>
            {{-- END CARD --}}
        </div>
    </div>
</div>

@push('js')
    <!-- FullCalendar from CDN -->
    <script src="{{ asset('alte4/dist/js/full_calendar.min.js') }}"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: siteURL + '/get-events',
        eventColor: '#28a745',
        eventTextColor: '#fff',
        });
        calendar.render();
    });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Get the height of the Calendar Card's body
            const calendarBody = document.getElementById('calendar-body');
            if (!calendarBody) return;

            const calendarHeight = calendarBody.offsetHeight;
            const noticeCardBody = document.querySelector('.card-body-scroll');
            if (!noticeCardBody) return;
            noticeCardBody.style.maxHeight = (calendarHeight - 20) + 'px';
        });

        // Use a debounced window resize listener to recalculate height when the browser size changes
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                const calendarBody = document.getElementById('calendar-body');
                const noticeCardBody = document.querySelector('.card-body-scroll');

                if (calendarBody && noticeCardBody) {
                    const calendarHeight = calendarBody.offsetHeight;
                    noticeCardBody.style.maxHeight = (calendarHeight - 20) + 'px';
                }
            }, 150);
        });
        </script>
@endpush
