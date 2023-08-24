@extends('layouts.admin')

@section('style')
    <style>
        .quiz-choice:hover {
            color: {{ $settings->site_primary_color }};
        }

        .quiz-choice {
            transition: .2s;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <h3 class="m-0 fs-5">Participate in the quiz - {{ $quiz_info->quiz_name }}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="mb-4 table-striped table-bordered table text-center align-middle">
                            <tr>
                                <th>Course Category</th>
                                <th>Course Type</th>
                                <th>Quiz Name</th>
                                <th>Total Questions</th>
                                <th>Total Marks</th>
                                <th>Quiz Time Limit</th>
                            </tr>
                            <tr>
                                <td>
                                    @php
                                        if ($quiz_info->course_id == '1') {
                                            echo 'Car (Manual)';
                                        } elseif ($quiz_info->course_id == '2') {
                                            echo 'Car (Auto)';
                                        } elseif ($quiz_info->course_id == '3') {
                                            echo 'Bike';
                                        } else {
                                            echo 'Scooter';
                                        }
                                        
                                    @endphp
                                </td>
                                <td>
                                    @php
                                        if ($quiz_info->course_type == '0') {
                                            echo 'Short';
                                        } else {
                                            echo 'Long';
                                        }
                                        
                                    @endphp
                                </td>
                                <td>{{ $quiz_info->quiz_name }}</td>
                                <td>
                                    @php
                                        if ($quiz_info->total_questions) {
                                            echo $quiz_info->total_questions;
                                        } else {
                                            echo '0';
                                        }
                                        
                                    @endphp
                                </td>
                                <td>
                                    @php
                                        if ($quiz_info->total_marks) {
                                            echo $quiz_info->total_marks;
                                        } else {
                                            echo '0';
                                        }
                                        
                                    @endphp
                                </td>
                                <td>{{ $quiz_info->time_limit }} Mins</td>
                            </tr>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-9 mx-auto mt-5">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Quiz Questions</h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.quiz.submit', $quiz_info->id) }}" method="POST" id="quiz-submit-form">
                                        @csrf
                                        @forelse ($questions as $key => $question)
                                            <div class="ps-5 py-4" style="{{ $key % 2 == 0 ? 'background: #0000000c' : '' }}">
                                                {{-- questions --}}
                                                <div class="row">
                                                    <div class="col-10">
                                                        <h5 class="mb-3">{{ $key + 1 . '. ' . $question->question }}</h5>
                                                    </div>
                                                    <div class="col-2">
                                                        <span>Marks: {{ $question->marks }}</span>
                                                    </div>
                                                </div>
                                                @php
                                                    $q_choices = $choices->where('question_id', $question->id);
                                                @endphp
                                                <div class="row justify-content-between">
                                                    @foreach ($q_choices as $i => $choice)
                                                        <div class="col-3">
                                                            <div class="d-flex quiz-choice" style="font-size: 15px">
                                                                <input class="me-2 cursor-pointer" type="radio" name="{{ 'ans' . $key + 1 }}" id="{{ 'option' . $i + 1 }}" value="{{ $choice->id }}" /> <label class="cursor-pointer" for="{{ 'option' . $i + 1 }}">{{ $choice->choice }}</label>
                                                            </div>
                                                        </div>
                                                        @error('ans' . $key + 1)
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    @endforeach
                                                </div>
                                            </div>
                                        @empty
                                            <p>No Qs Found</p>
                                        @endforelse
                                        <input class="" readonly hidden type="text" name="questions" value="{{ $questions }}" />
                                        <button type="submit" class="btn btn-primary btn-sm mt-5 mb-3 fs-6 d-block mx-auto py-2 px-3 submit-btn">Submit
                                            Now</button>
                                    </form>
                                </div>
                            </div>
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
    @if (session('startQuiz'))
        <script>
            Swal.fire(
                'Good luck!',
                "{{ session('startQuiz') }}",
                'info',
            )
        </script>
    @endif

    {{-- action="{{ route('admin.quiz.submit', $quiz_info->id) }}" method="POST"  --}}
    <script>
        let submitForm = document.getElementById('quiz-submit-form');
        $('#quiz-submit-form').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure to submit the quiz now?',
                text: "You can't revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "Yes, I'm sure!",
            }).then((result) => {
                if (result.isConfirmed) {
                    submitForm.submit();
                }
            })

        });

        setTimeout(() => {
            Swal.fire(
                'Only 2 minutes left!',
                "Please answer all the questions fast.",
                'warning'
            );
        }, ({{ $quiz_info->time_limit }} - 2) * 60 * 1000);

        setTimeout(() => {
            Swal.fire(
                'Sorry!',
                "You ran out of time. So the quiz will be submitted automatically now.",
                'warning'
            );
        }, {{ $quiz_info->time_limit }} * 60 * 1000);

        setTimeout(() => {
            submitForm.submit();
        }, ({{ $quiz_info->time_limit }} * 60 * 1000) + 2000);
    </script>
@endsection
