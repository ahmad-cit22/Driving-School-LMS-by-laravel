@extends('layouts.admin')
@section('top-btn')
    {{-- Get Invoice PDF  --}}
    <a href="{{ route('admin.enroll_form.generate', $enroll->id) }}" class="btn btn-small site-bg-primary text-white ms-3" style="font-size: 14px"><i class="fa-regular fa-file me-2"></i>Get Enrollment Form</a>
    @if ($enroll->payment_status)
        @if ($enroll->paid > 0)
            <a href="{{ route('admin.enroll_invoice.generate', $enroll->id) }}" class="btn btn-small site-bg-primary text-white ms-3" style="font-size: 14px"><i class="fa-regular fa-file me-2"></i>Get Invoice</a>
        @endif
    @endif
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="fs-5 fw-normal m-0">Enrollment Details</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 pb-2">Enroll ID: #00{{ $enroll->id }}</div>
                <div class="col-md-6 pb-2">Student ID: {{ $enroll->user->id_no }}</div>
                <div class="col-md-6 pb-2">Student Name: {{ $enroll->user->name }}</div>
                <div class="col-md-6 pb-2">Student Contant No: {{ $enroll->user->mobile }}</div>
                <div class="col-md-6 pb-2">Branch: {{ $enroll->branch->branch_name }}</div>
                <div class="col-md-6 pb-2">Start Date: {{ $enroll->start_date->format('d-m-Y') }}</div>
                <div class="col-md-6 pb-2">Course Category: {{ $enroll->category->category_name }}</div>
                <div class="col-md-6 pb-2">Course Type: {{ $enroll->type->type_name }} ({{ $enroll->type->duration }} Days)</div>
                <div class="col-md-6 pb-2">Slot: {{ Carbon\Carbon::parse($enroll->slot->start_time)->format('h:i A') }} - {{ Carbon\Carbon::parse($enroll->slot->end_time)->format('h:i A') }} <button class="btn btn-small bg-secondary text-white change-slot ms-3" data-id="{{ $enroll->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Change Course Slot" style="font-size: 12px">Change Slot</button></div>
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
                @hasrole([1, 2, 4])
                    <div class="col-md-6 pb-2">Course Fee (Payable Amount): <span class="fw-bold site-text-primary"> BDT {{ $enroll->payable_amount }}</span></div>
                    <div class="col-md-6 pb-2">
                        @if ($enroll->payment_status)
                            @if ($enroll->paid == $enroll->payable_amount)
                                Payment Status: <span class="fw-bold text-success">Paid</span><a href="{{ route('admin.enroll_invoice.generate', $enroll->id) }}" class="ms-3 d-inline-block site-text-primary" style="font-size: 14px"><i class="fa-regular fa-file me-2"></i>Get Invoice</a>
                            @else
                                @if ($enroll->paid == 0)
                                    Payment Status: <span class="fw-bold text-danger">Not Paid</span>
                                @else
                                    Payment Status: <span class="fw-bold site-text-secondary">Has Due (&#2547;{{ $enroll->payable_amount - $enroll->paid }})</span><a href="{{ route('admin.enroll_invoice.generate', $enroll->id) }}" class="ms-3 d-inline-block site-text-primary" style="font-size: 14px"><i class="fa-regular fa-file me-2"></i>Get Invoice</a>
                                @endif
                            @endif
                        @else
                            Payment Status: <span class="fw-bold text-danger">Not Paid</span>
                        @endif

                    </div>
                @endhasrole
                @hasrole([1, 2])
                    <div class="col-md-6 pb-2 mt-2">
                        <button class="rcv-payment mt-2 d-inline-block btn btn-sm site-bg-primary text-white" data-id="{{ $enroll->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Due Pay">Receive Payment (Offline)</button>
                    </div>
                @endhasrole

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div id='calendar'></div>
        </div>
    </div>

    <!-- rcv pay Modal -->
    <div class="modal fade" id="rcvPay" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="width: 600px">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Receive Payment</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" class="needs-validation" novalidate action="{{ route('enroll.rcv.pay') }}">
                        @csrf
                        <div class="row">
                            <input readonly hidden type="number" class="form-control" name="enroll_id" value="{{ $enroll->id }}">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="due">Due Amount</label>
                                    <input readonly type="number" class="form-control" name="due" id="due" placeholder="" value="{{ $enroll->payment_status ? $enroll->payable_amount - $enroll->paid : $enroll->payable_amount }}" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="pay">Now Receiveing</label>
                                    <input type="number" class="form-control" id="pay" name="pay" placeholder="Enter the amount in BDT" value="{{ old('pay') }}" required>
                                </div>
                            </div>
                        </div>
                        <p class="site-text-secondary">Click on the 'Confirm Now' button when you have the payment received.</p>
                        <hr class="mb-4">
                        <button class="btn btn-primary btn-sm d-block ms-auto" id="sslczPayBtn" token="if you have any token validation" postdata="your javascript arrays or objects which requires in backend" order="If you already have the transaction generated for current order" endpoint=""> Confirm Now </button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- slot change --}}
    <div class="modal fade" id="changeSlot" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-1">
                <form id="change-slot-form" action="{{ route('admin.slot_change.change', $enroll->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Change Course Slot</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="course_slot mb-3">Course Slot</label>
                        <select name="slot_id" id="course_slot" class="form-control select2" required>
                            <option></option>
                            @foreach ($slots as $slot)
                                <option value="{{ $slot->id }}">{{ Carbon\Carbon::parse($slot->start_time)->format('h:i A') . ' - ' . Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}</option>
                            @endforeach
                        </select>
                        <div class="error"></div>
                        <div class="error"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Change Now</button>
                    </div>
                </form>
            </div>
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
        // change-slot
        $('.change-slot').click(function() {
            $('#changeSlot').modal('show');
        });

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

    <script>
        //rcv pay offline
        $('.rcv-payment').click(function() {
            $('#rcvPay').modal('show');
        });
    </script>
@endsection
