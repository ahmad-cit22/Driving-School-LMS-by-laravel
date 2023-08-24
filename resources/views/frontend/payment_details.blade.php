@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="fs-5 fw-normal m-0">Short Details</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 pb-2">Student Name: {{ $enroll->user->name }}</div>
                <div class="col-md-6 pb-2">Student Contant No: {{ $enroll->user->mobile }}</div>
                <div class="col-md-6 pb-2">Branch: {{ $enroll->branch->branch_name }}</div>
                <div class="col-md-6 pb-2">Start Date: {{ $enroll->start_date->format('d-m-Y') }}</div>
                <div class="col-md-6 pb-2">Course Category: {{ $enroll->category->category_name }}</div>
                <div class="col-md-6 pb-2">Course Type: {{ $enroll->type->type_name }} ({{ $enroll->type->duration }} Days)</div>
                <div class="col-md-6 pb-2">Slot: {{ Carbon\Carbon::parse($enroll->slot->start_time)->format('h:i A') }}-{{ Carbon\Carbon::parse($enroll->slot->end_time)->format('h:i A') }}</div>
                <div class="col-md-6">
                    Status:
                    @if ($enroll->status)
                        <span class="badge rounded-pill bg-success">Approved</span>
                    @else
                        <span class="badge rounded-pill bg-danger">Pending</span>
                        @if (auth()->user()->hasRole([1, 2]))
                            <button class="badge rounded-pill bg-success border-0 approve" data-id="{{ $enroll->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approve This"><i class="fa-solid fa-check"></i></button>
                        @endif
                    @endif
                </div>
                <div class="col-md-6 pb-2">Course Fee: <span class="fw-bold site-text-primary"> BDT {{ $enroll->price }}</span></div>
                <div class="col-md-6 pb-2">
                    @if ($enroll->paid == $enroll->price)
                        Payment Status: <span class="fw-bold text-success">Paid</span>
                    @else
                        @if ($enroll->paid == 0)
                            Payment Status: <span class="fw-bold text-danger">Not Paid</span>
                        @else
                            Payment Status: <span class="fw-bold text-warning">Has Due (&#2547;{{ $enroll->price - $enroll->paid }})</span>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div id='calendar'></div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        .fc-h-event .fc-event-title {
            font-weight: 600;
            font-family: Roboto;
            -webkit-font-smoothing: antialiased;
            text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.004);
        }
    </style>
@endsection

@section('script')
    <script>
        @if (auth()->user()->hasRole([1, 2]))
            $('.approve').click(function() {
                let id = $(this).data('id');
                let url = "{{ route('admin.enroll.approve', ':id') }}";
                url = url.replace(':id', id);
                warning(url);
            });
        @endif

        let calendarEl = document.getElementById('calendar');

        let calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next,today',
                center: 'title',
                right: 'dayGridMonth'
            },
            displayEventEnd: true,
            initialDate: "{{ $enroll->start_date->format('Y-m-d') }}",
            navLinks: true, // can click day/week names to navigate views
            editable: false,
            dayMaxEvents: true, // allow "more" link when too many events
            events: "{{ route('admin.enroll.fetch', $enroll->id) }}",
            eventDisplay: 'block',
            eventTimeFormat: {
                hour: 'numeric',
                meridiem: 'short'
            },
        });

        calendar.render();
    </script>
@endsection
