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
    {{-- overall report --}}
    <div class="row mb-5">
        <div class="col">
            <table class="fs-6 table table-striped table-bordered">
                <tr>
                    <th>Enroll ID: #00{{ $enroll->id }}</th>
                    <th>Branch: {{ $enroll->branch->branch_name }}</th>
                    <th>Student ID: {{ $enroll->user->id_no }}</th>
                <tr>
                <tr>
                    <th>Course Category: {{ $enroll->category->category_name }}</th>
                    <th>Course Type: {{ $enroll->type->type_name }} ({{ $enroll->type->duration }} Days)</th>
                    <th>Course Slot: {{ Carbon\Carbon::parse($enroll->slot->start_time)->format('h:i A') }} - {{ Carbon\Carbon::parse($enroll->slot->end_time)->format('h:i A') }} <button class="btn btn-small bg-secondary text-white change-slot ms-3" data-id="{{ $enroll->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Apply for Changing Slot" style="font-size: 12px">Apply for Changing</button>
                </tr>
                <tr>
                    <th>Course Fee (Payable Amount): &#2547; {{ $enroll->payable_amount }}</th>
                    @if ($enroll->payment_status)
                        <th class="{{ $enroll->paid == $enroll->payable_amount ? 'text-success' : 'text-danger' }}"> {{ $enroll->paid == $enroll->payable_amount ? 'Paid' : 'Not Paid (Due Amount: BDT ' . $enroll->payable_amount - $enroll->paid . ')' }} </th>
                    @else
                        <th class="fw-bold text-danger">{{ 'Not Paid (Due Amount: BDT ' . $enroll->payable_amount . ')' }}</th>
                    @endif
                    @if ($enroll->payment_status)
                        <th class="{{ $enroll->paid == $enroll->payable_amount ? 'text-success' : 'text-danger' }}">
                            Payment Due: {{ $enroll->paid == $enroll->payable_amount ? 'No Due' : 'BDT ' . $enroll->payable_amount - $enroll->paid }}
                        </th>
                    @else
                        <th class="fw-bold text-danger"> Payment Due: {{ 'BDT ' . $enroll->payable_amount }}</th>
                    @endif

                </tr>
            </table>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-7 mx-auto">
            <h4 class="text-center mb-2">Course Progress</h4>
            <div class="mt-5 row justify-content-between">
                <div class="col-5 rounded-3 pb-4 bg-white">
                    <h5 class="text-center mb-4 mt-4">Classes Completed</h5>
                    <div class="by-device-container">
                        <canvas id="classProgress"></canvas>
                    </div>
                    <div class="row py-1">
                        <div class="col-8 px-4 mx-auto">
                            <h4 class="text-center py-3">{{ $class_count == 0 ? 0 : $class_attended_per }}%</h4>
                            <ul class="list-group list-group-flush">
                                <li class="mb-2 d-flex align-items-center justify-content-between border-0">
                                    <i class="fa fa-note me-2 text-orange"></i> <span>Total Classes - </span> <span>{{ $enroll->type->duration }}</span>
                                </li>
                                <li class="mb-2 d-flex align-items-center justify-content-between border-0">
                                    <i class="fa fa-note me-2 text-success"></i> <span>Class Completed - </span> <span>{{ $class_attended }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-5 rounded-3 pb-4 bg-white">
                    <h5 class="text-center mb-4 mt-4">Quizzes Completed</h5>
                    @if ($quiz_count > 0)
                        <div class="by-device-container">
                            <canvas id="quizProgress"></canvas>
                        </div>
                        <div class="row py-1">
                            <div class="col-8 px-4 mx-auto">
                                <h4 class="text-center py-3">{{ $quiz_count == 0 ? 0 : $passed_quiz_per }}%</h4>
                                <ul class="list-group list-group-flush">
                                    <li class="mb-2 d-flex align-items-center justify-content-between border-0">
                                        <i class="fa fa-note me-2 text-orange"></i> <span>Total Quizzes - </span> <span>{{ $quiz_count }}</span>
                                    </li>
                                    <li class="mb-2 d-flex align-items-center justify-content-between border-0">
                                        <i class="fa fa-note me-2 text-success"></i> <span>Quizzes Passed - </span> <span>{{ $passed_quiz_count }}</span>
                                    </li>
                                </ul>
                                <div class="row justify-content-center pt-3">
                                    <div class="col-9 mx-auto d-flex justify-content-center">
                                        @if ($class_attended_per == 100)
                                            <a href="{{ route('admin.quiz.list', $enroll->id) }}" class="btn btn-sm btn-info text-white">Quizzes</a>
                                        @else
                                            <button class="btn btn-secondary text-white ms-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="You can't browse quizzes until you have attended all the classes.">
                                                Quizzes
                                            </button>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-orange text-center">There is no quiz available yet for this course.</p>
                    @endif
                </div>
            </div>
            <div class="row justify-content-center pt-5">
                <div class="col-9 d-flex justify-content-center mx-auto">
                    {{-- Video Courses --}}
                    @if (App\Models\VideoCourse::where('course_category', $enroll->course_category)->where('course_type', $enroll->course_type)->exists())
                        <a href="{{ route('admin.student.vid_courses') }}" class="btn bg-orange text-white" style="width: 36%;">Browse Video Courses</a>
                    @endif

                    {{-- Give Review  --}}
                    @if ($class_attended_per == 100)
                        @if ($review_exists)
                            <button class="btn btn-secondary text-white ms-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="You have given review already!">
                                Give Review
                            </button>
                        @else
                            <button class="btn site-bg-secondary text-white ms-3 give-review" data-id="{{ $enroll->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Give Your Review"><i class="me-2 fa-solid fa-star"></i>Give Review</button>
                        @endif
                    @else
                        <button class="btn btn-secondary text-white ms-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="You can't give review until you have attended all the classes."><i class="me-2 fa-solid fa-star"></i>
                            Give Review
                        </button>
                    @endif

                    {{-- Get Certificate &  --}}
                    @if ($class_attended_per == 100 && $passed_quiz_per == 100)
                        <a href="{{ route('admin.certificate.view', $enroll->id) }}" class="btn site-bg-primary text-white ms-3" style="width: 30%;"><i class="fa-regular fa-file-certificate me-2"></i>Get Certificate</a>
                    @else
                        <button class="btn btn-secondary text-white ms-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="You can't get the certificate until you have attended all the classes & passed all the quizzes."><i class="fa-regular fa-file-certificate me-2"></i>
                            Get Certificate
                        </button>
                    @endif

                </div>
            </div>

            @if ($course_docs->count() > 0)
                <div class="row mt-5">
                    <div class="card mt-3 p-3">
                        <div class="card-header">
                            <h5 class="m-0 ">Course Resources</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table">
                                <table class="table table-striped datatable table-bordered text-center align-middle">
                                    <thead>
                                        <tr>
                                            <th width="7%">SL</th>
                                            <th width="12%">File Name</th>
                                            <th width="12%">File Size</th>
                                            <th width="">Note</th>
                                            <th width='8%'>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($course_docs as $key => $doc)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $doc->name }}</td>
                                                <td>{{ $doc->size }}</td>
                                                <td>{{ $doc->note ? $doc->note : '--' }}</td>
                                                <td>
                                                    <a href="{{ route('admin.download.doc', $doc->id) }}" class="btn btn-primary btn-sm download-doc" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download File"><i class="fa-solid fa-download"></i></a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5">No Resource Found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- give review Modal -->
    <div class="modal fade" id="giveReview" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-1">
                <form id="give-review-form">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Give Review</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h3>...</h3>
                        <div class="error"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- slot change --}}
    <div class="modal fade" id="changeSlot" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-1">
                <form id="change-slot-form" action="{{ route('admin.slot_change.apply', $enroll->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Apply for Slot Change</h1>
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
                        <button type="submit" class="btn btn-primary">Send Application</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        form .error {
            font-size: .9em;
            color: #dc3545;
            display: none;
        }
    </style>
@endsection

@section('script')
    <script src="{{ asset('assets/backend') }}/plugins/chartjs/js/Chart.min.js"></script>
    <script src="{{ asset('assets/backend') }}/plugins/chartjs/js/Chart.extension.js"></script>
    <script src="{{ asset('assets/backend') }}/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
    <script>
        // classProgress
        new Chart(document.getElementById("classProgress"), {
            type: 'doughnut',
            data: {
                labels: ["Classes Completed", "Remaining Classes"],
                datasets: [{
                    label: "Course Progress",
                    backgroundColor: ["#12bf24", "#88888850"],
                    data: [{{ $class_attended }}, {{ $enroll->type->duration - $class_attended }}]
                }]
            },
            options: {
                maintainAspectRatio: false,
                cutoutPercentage: 77,
                legend: {
                    position: 'bottom',
                    display: false,
                    labels: {
                        boxWidth: 8
                    }
                },
                tooltips: {
                    displayColors: false,
                },
            }
        });
    </script>

    <script>
        // quizProgress
        new Chart(document.getElementById("quizProgress"), {
            type: 'doughnut',
            data: {
                labels: ["Quizzes Passed", "Remaining Quizzes"],
                datasets: [{
                    label: "Quiz Progress",
                    backgroundColor: ["#12bf24", "#88888850"],
                    data: [{{ $passed_quiz_count }}, {{ $quiz_count - $passed_quiz_count }}]
                }]
            },
            options: {
                maintainAspectRatio: false,
                cutoutPercentage: 77,
                legend: {
                    position: 'bottom',
                    display: false,
                    labels: {
                        boxWidth: 8
                    }
                },
                tooltips: {
                    displayColors: false,
                },
            }
        });
    </script>

    <script>
        // give-review
        $('.give-review').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.give.review', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                method: 'get',
                url: url,
                success: function(response) {
                    $('#giveReview').modal('show');
                    $('#giveReview .modal-body').html(response);
                }
            })
        });

        // change-slot
        $('.change-slot').click(function() {
            $('#changeSlot').modal('show');
        });

        $('#give-review-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: "{{ route('admin.review.add') }}",
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        let errors = response.errors;
                        let errorsHtml = '<ul class="m-0 mt-2 fw-light">';
                        $.each(errors, function(key, value) {
                            errorsHtml += '<li class= "fw-bold">' + value + '</li>';
                        });
                        errorsHtml += '</ul>';
                        $('#give-review-form .error').html(errorsHtml);
                        $('#give-review-form .error').show();
                    }
                }
            });
        });
    </script>

    @if (session('reviewSuccess'))
        <script>
            Swal.fire(
                'Done',
                "{{ session('reviewSuccess') }}",
                'success',
            )
        </script>
    @endif
@endsection
