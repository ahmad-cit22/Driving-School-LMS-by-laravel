@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- Quiz List -->
            <div class="card">
                <div class="card-header">
                    <h3 class="m-0 fs-5">Quiz List</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="datatable table-striped table-bordered table text-center align-middle">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Course Category</th>
                                    <th>Course Type</th>
                                    <th>Quiz Name</th>
                                    <th>Total Questions</th>
                                    <th>Total Marks</th>
                                    <th>Quiz Time Limit</th>
                                    <th>Quiz Status</th>
                                    {{-- <th>Quiz Privacy</th> --}}
                                    <th>Questions</th>
                                    <th width='9%'>Quiz Reports</th>
                                    <th width='7%'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($quizzes as $key => $quiz)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td> {{ $quiz->category->category_name }} </td>
                                        <td> {{ $quiz->type->type_name }} </td>
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
                                        {{-- <td>
                                        @php
                                            if ($quiz->quiz_privacy == '0') {
                                                echo 'Public';
                                            } else {
                                                echo 'Our Students Only';
                                            }
                                            
                                        @endphp
                                    </td> --}}
                                        <td>
                                            <a href="{{ route('admin.quiz.questions', $quiz->id) }}" class="btn btn-success btn-sm text-white">Questions</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.quiz.report', $quiz->id) }}" class="btn btn-info btn-sm text-white">Quiz Report</a>
                                        </td>
                                        <td>
                                            <button class="btn btn-info text-white btn-sm edit-quiz" data-id="{{ $quiz->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="fa-solid fa-pencil"></i> </button>
                                            <button class="btn btn-danger btn-sm delete-quiz" data-id="{{ $quiz->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
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

        </div>
    </div>

    <div class="row">

        {{-- Quiz Add Model --}}
        <div class="col-12 col-md-7 col-lg-6 mx-auto mt-3 mb-5">
            <div class="card">
                <div class="card-header">
                    <h3 class="m-0 fs-5">Add New Quiz</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.quizzes.add') }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">Course Category</label>
                            <select class="form-control cursor-pointer" name="course_category" id="course_category" required>
                                <option value=""> -- Select Course Category -- </option>
                                @foreach ($course_categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                            @error('course_category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Course Type</label>
                            <select class="form-control cursor-pointer" name="course_type" id="course_type" required>
                                <option value=""> -- Select Course Type -- </option>
                                @foreach ($course_types as $type)
                                    <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                                @endforeach
                            </select>
                            @error('course_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Quiz Name</label>
                            <input type="text" class="form-control @error('quiz_name')is-invalid @enderror" name="quiz_name" value="{{ old('quiz_name') }}" placeholder="Enter Quiz Name" required>
                            @error('quiz_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Quiz Time Limit (Minutes)</label>
                            <input type="number" class="form-control @error('time_limit')is-invalid @enderror" name="time_limit" value="{{ old('time_limit') }}" placeholder="Enter Time Limit (Minutes)" required>
                            @error('time_limit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Quiz Status</label>
                            <select class="form-control cursor-pointer" name="quiz_status" id="quiz_status" required>
                                <option value=""> -- Set Quiz Status -- </option>
                                <option value="0" selected>Upcoming</option>
                                <option value="1">Ongoing</option>
                                <option value="2">Closed</option>
                            </select>
                            @error('quiz_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button class="btn btn-primary btn-sm mt-2 fs-6">Add Now</button>
                    </form>
                </div>
            </div>

        </div>

    </div>

    <!-- Quiz Edit Modal -->
    <div class="modal fade" id="editQuiz" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="edit-quiz-form">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Edit Course Quiz</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h3>...</h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
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
    @if (session('addSuccess'))
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: '{{ session('addSuccess') }}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    @if (session('editSuccess'))
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: '{{ session('editSuccess') }}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    @if (session('dltSuccess'))
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: '{{ session('dltSuccess') }}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif

    @if (session('reportErr'))
        <script>
            Swal.fire(
                'Sorry!',
                "{{ session('reportErr') }}",
                'error'
            )
        </script>
    @endif
    @if (session('participationError'))
        <script>
            Swal.fire(
                'Sorry!',
                "{{ session('participationError') }}",
                'error'
            )
        </script>
    @endif

    <script>
        //course quiz
        $('.edit-quiz').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.quiz.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                method: 'get',
                url: url,
                success: function(response) {
                    $('#editQuiz').modal('show');
                    $('#editQuiz .modal-body').html(response);
                }
            })
        });

        $('#edit-quiz-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: "{{ route('admin.quiz.update') }}",
                data: $(this).serialize(),
                success: function(response) {
                    window.location.reload();
                }
            });
        });

        $('.delete-quiz').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.quiz.delete', ':id') }}";
            url = url.replace(':id', id);
            delete_warning(url);
        });
    </script>
@endsection
