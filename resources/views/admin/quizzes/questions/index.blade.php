@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <h3 class="m-0 fs-5">Questions of Quiz - {{ $quiz_info->quiz_name }}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table-striped table-bordered table text-center align-middle">
                            <tr>
                                <th>SL</th>
                                <th>Question</th>
                                <th>Question Type</th>
                                <th>Marks</th>
                                <th>Action</th>
                            </tr>
                            @forelse ($questions as $key => $question)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $question->question }}</td>
                                    <td>
                                        @php
                                            if ($question->question_type == '0') {
                                                echo 'MCQ';
                                            } elseif ($question->question_type == '1') {
                                                echo 'True/False';
                                            } else {
                                                echo 'Descriptive';
                                            }
                                        @endphp
                                    </td>
                                    <td>{{ $question->marks }}</td>
                                    <td>
                                        <button class="btn btn-info text-white btn-sm edit-question" data-id="{{ $question->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="fa-solid fa-pencil"></i> </button>
                                        <button class="btn btn-danger btn-sm delete-question" data-id="{{ $question->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">No Question Found</td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row">

        {{-- Question Add Model --}}
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="m-0 fs-5">Add New Question For This Quiz</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.quiz.questions.store', $quiz_info->id) }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">Question</label>
                            <input type="text" class="form-control @error('question')is-invalid @enderror" name="question" value="{{ old('question') }}" placeholder="Enter Question" required>
                            @error('question')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Question Type</label>
                            <select class="form-control cursor-pointer" name="question_type" id="question_type" required>
                                <option value=""> -- Set Question Type -- </option>
                                <option value="0" selected>MCQ</option>
                                {{-- <option value="1">True/False</option>
                                <option value="2">Descriptive</option> --}}
                            </select>
                            @error('question_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- add choices --}}
                        <div class="mb-2">
                            <label class="form-label">Add Choices for the Question</label>
                            <div class="row">
                                <div class="col-md-3">

                                    <input type="text" class="form-control @error('choice')is-invalid @enderror" name="choice[]" value="{{ old('choice[]') }}" placeholder="Enter a Choice" required>
                                </div>
                                <div class="col-md-3">

                                    <input type="text" class="form-control @error('choice')is-invalid @enderror" name="choice[]" value="{{ old('choice[]') }}" placeholder="Enter a Choice" required>
                                </div>
                                <div class="col-md-3">

                                    <input type="text" class="form-control @error('choice')is-invalid @enderror" name="choice[]" value="{{ old('choice[]') }}" placeholder="Enter a Choice" required>
                                </div>
                                <div class="col-md-3">

                                    <input type="text" class="form-control @error('choice')is-invalid @enderror" name="choice[]" value="{{ old('choice[]') }}" placeholder="Enter a Choice" required>
                                </div>
                            </div>
                            @error('choice[]')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="form-label">Right Answer</label>
                                <select class="form-control cursor-pointer" name="right_answer" id="right_answer" required>
                                    <option value=""> -- Set Right Answer -- </option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                                @error('right_answer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="">
                                    <label class="form-label">Marks</label>
                                    <select class="form-control cursor-pointer" name="marks" id="marks" required>
                                        <option value=""> -- Set the Marks for the Question -- </option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                    @error('marks')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary btn-sm mt-2 fs-6">Add Now</button>
                    </form>
                </div>
            </div>

        </div>

        <!-- Question Edit Model -->
        <div class="row">
            <div class="col-md-12">
                <div class="modal fade" id="editQuestion" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="edit-question-form">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Edit Course Question</h1>
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
        <script>
            //question
            $('.edit-question').click(function() {
                let id = $(this).data('id');
                let url = "{{ route('admin.question.edit', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    method: 'get',
                    url: url,
                    success: function(response) {
                        $('#editQuestion').modal('show');
                        $('#editQuestion .modal-body').html(response);
                    }
                })
            });

            $('#edit-question-form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    method: 'POST',
                    url: "{{ route('admin.question.update') }}",
                    data: $(this).serialize(),
                    success: function(response) {
                        window.location.reload();
                    }
                });
            });

            $('.delete-question').click(function() {
                let id = $(this).data('id');
                let url = "{{ route('admin.question.delete', ':id') }}";
                url = url.replace(':id', id);
                delete_warning(url);
            });
        </script>
    @endsection
