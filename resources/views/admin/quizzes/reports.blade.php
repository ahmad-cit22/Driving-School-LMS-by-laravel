@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- Quiz List -->
            <div class="card">
                <div class="card-header">
                    <h3 class="m-0 fs-5">Reports of the Quiz - {{ $quiz->quiz_name }}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="datatable table-striped table-bordered table text-center align-middle">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Participant Name</th>
                                    <th>Score</th>
                                    <th>Score (%)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($reports as $key => $report)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            @php
                                                $enrollment = $enrollments->find($report->enrollment_id);
                                                $student = $students->find($enrollment->user_id);
                                                
                                                echo $student->name;
                                                
                                            @endphp
                                        </td>
                                        <td>{{ $report->score_in_num }} Out of {{ $quiz->total_marks }}</td>
                                        <td>{{ number_format(($report->score_in_num * 100) / $quiz->total_marks) }}%</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm edit-report" data-id="{{ $report->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="fa-solid fa-pencil"></i></button>
                                            <button class="btn btn-danger btn-sm delete-report" data-id="{{ $report->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11">No Reports Found</td>
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

        <!-- report Edit Model -->
        <div class="modal fade" id="editReport" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="edit-report-form">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Edit Quiz Report</h1>
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
        {{-- @if (session('dltSuccess'))
            <script>
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ session('dltSuccess') }}',
                    showConfirmButton: false,
                    timer: 1500
                })
            </script>
        @endif --}}

        @if (session('reportErr'))
            <script>
                Swal.fire(
                    'Sorry!',
                    "{{ session('reportErr') }}",
                    'error'
                )
            </script>
        @endif



        <script>
            // edit course
            $('.edit-report').click(function() {
                let id = $(this).data('id');
                let url = "{{ route('admin.quiz.report.edit', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    method: 'get',
                    url: url,
                    success: function(response) {
                        $('#editReport').modal('show');
                        $('#editReport .modal-body').html(response);
                    }
                })
            });

            $('#edit-report-form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    method: 'POST',
                    url: "{{ route('admin.quiz.report.update') }}",
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
                            $('#edit-report-form .error').html(errorsHtml);
                            $('#edit-report-form .error').show();

                        }
                    }
                });
            });

            $('.delete-report').click(function() {
                let id = $(this).data('id');
                let url = "{{ route('admin.quiz.report.delete', ':id') }}";
                url = url.replace(':id', id);
                delete_warning(url);
            });
        </script>
    @endsection
