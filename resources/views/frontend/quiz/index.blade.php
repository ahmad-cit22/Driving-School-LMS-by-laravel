@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- Quiz List -->
            @if ($has_participated != null)
                <div class="card">
                    <div class="card-header">
                        <h3 class="m-0 fs-5">Quiz List</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="datatable table-striped table-bordered table text-center align-middle">
                                <thead>
                                    <tr>
                                        <th>Quiz Code</th>
                                        <th>Course Category</th>
                                        <th>Course Type</th>
                                        <th>Quiz Name</th>
                                        <th>Total Questions</th>
                                        <th>Total Marks</th>
                                        <th>Quiz Time Limit</th>
                                        <th>Quiz Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $has_participate = $has_participated->get();
                                        $sl = 1;
                                        
                                    @endphp
                                    @forelse ($quizzes as $key => $quiz)
                                        @php
                                            $enroll = App\Models\Enroll::where('course_category', $quiz->course_id)
                                                ->where('user_id', Auth::id())
                                                ->first();
                                            if ($enroll) {
                                                $has_report = App\Models\QuizScore::where('quiz_id', $quiz->id)
                                                    ->where('enrollment_id', $enroll->id)
                                                    ->exists();
                                                $hasPassed = App\Models\QuizScore::where('quiz_id', $quiz->id)
                                                    ->where('enrollment_id', $enroll->id)
                                                    ->where('score_in_num', '>=', $quiz->total_marks * 0.6)
                                                    ->exists();
                                            }
                                        @endphp

                                        @if ($enroll)
                                            <tr>
                                                <td>#00{{ $sl }}</td>
                                                <td>
                                                    @php
                                                        if ($quiz->course_id == '1') {
                                                            echo 'Car (Manual)';
                                                        } elseif ($quiz->course_id == '2') {
                                                            echo 'Car (Auto)';
                                                        } elseif ($quiz->course_id == '3') {
                                                            echo 'Bike';
                                                        } elseif ($quiz->course_id == '12') {
                                                            echo 'Scooter';
                                                        }
                                                    @endphp
                                                </td>
                                                <td>
                                                    @php
                                                        if ($quiz->course_type == '1') {
                                                            echo 'Short';
                                                        } elseif ($quiz->course_type == '2') {
                                                            echo 'Long';
                                                        }
                                                        
                                                    @endphp
                                                </td>
                                                <td>{{ $quiz->quiz_name }}</td>
                                                <td>
                                                    @php
                                                        if ($quiz->total_questions) {
                                                            echo $quiz->total_questions;
                                                        } else {
                                                            echo '0';
                                                        }
                                                        
                                                    @endphp
                                                </td>
                                                <td>
                                                    @php
                                                        if ($quiz->total_marks) {
                                                            echo $quiz->total_marks;
                                                        } else {
                                                            echo '0';
                                                        }
                                                        
                                                    @endphp
                                                </td>
                                                <td>{{ $quiz->time_limit }} Mins</td>
                                                <td>
                                                    @php
                                                        if ($quiz->quiz_status == '0') {
                                                            echo 'Upcoming';
                                                        } elseif ($quiz->quiz_status == '1') {
                                                            echo 'Ongoing';
                                                        } else {
                                                            echo 'Closed';
                                                        }
                                                        
                                                    @endphp
                                                </td>
                                                <td>
                                                    @if ($has_report)
                                                        <div class="row">
                                                            <div class="col-8 mx-auto">
                                                                @if ($hasPassed)
                                                                    <button class="btn btn-info text-white btn-sm" disabled>
                                                                        Completed Already
                                                                    </button>
                                                                @else
                                                                    <button class="btn btn-info text-white btn-sm participate-btn" value="{{ route('admin.quiz.participate', $quiz->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Participate in it whenever you are ready. You must aquire minimum 60% marks in order to pass.">
                                                                        Participate Again
                                                                    </button>
                                                                @endif
                                                                <button class="mt-1 btn btn-info text-white btn-sm view_report" value="{{ route('admin.quiz.view.report', $quiz->id) }}">
                                                                    View Report
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @else
                                                        @if ($quiz->quiz_status == '1')
                                                            <button class="btn btn-info text-white btn-sm participate-btn" value="{{ route('admin.quiz.participate', $quiz->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Participate in it whenever you are ready. You must aquire minimum 60% marks in order to pass.">
                                                                Participate
                                                            </button>
                                                        @else
                                                            <button class="btn btn-info text-white btn-sm btn-" value="" disabled>
                                                                Participate
                                                            </button>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                        @php
                                            $sl += 1;
                                        @endphp
                                    @empty
                                        <tr>
                                            <td colspan="11">No Quiz Found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif


        </div>
    </div>

    <!-- View Quiz Report Modal -->
    <div class="modal fade" id="viewReport" tabindex="-1" aria-hidden="true">
        <div class="row">
            <div class="col-12">
                <div class="modal-dialog">
                    <div class="modal-content" style="width: 135%;">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Quiz Report</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h3>...</h3>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        .slot-day {
            display: none;
        }

        form .error {
            font-size: .9em;
            color: #dc3545;
            display: none;
        }
    </style>
@endsection

@section('script')
    <script>
        $('.participate-btn').click(function() {
            let link = $(this).val();
            Swal.fire({
                title: 'Are you sure to start the quiz now?',
                text: "The quiz will be submitted automatically when the time limit exceeds.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "Yes, I'm sure!",
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = link;
                }
            })
        })

        $('.view_report').click(function() {
            let url = $(this).val();
            $.ajax({
                method: 'GET',
                url: url,
                success: function(response) {
                    $('#viewReport').modal('show');
                    $('#viewReport .modal-body').html(response);
                }
            });
        })
    </script>
    @if (session('finishedQuiz'))
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: '{{ session('finishedQuiz') }}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
@endsection
