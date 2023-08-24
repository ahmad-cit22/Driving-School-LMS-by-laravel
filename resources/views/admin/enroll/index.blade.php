@extends('layouts.admin')
@section('content')
    {{-- offline course enrolls --}}
    <div class="card">
        <div class="card-header">
            <h5>Offline Course Enrollments</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered align-middle text-center" style="width:100%">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Enroll ID</th>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Branch</th>
                            <th>Start Date</th>
                            <th>Course Category</th>
                            <th>Course Type</th>
                            <th>Slot/Batch</th>
                            <th>Status</th>
                            <th>Action</th>
                            @hasrole([1, 2, 3])
                                <th>Attendance</th>
                            @endhasrole
                            @hasrole([1, 2])
                                <th>Payment Status</th>
                                <th>Certificate</th>
                            @endhasrole
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($enrolls as $enroll)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>#00{{ $enroll->id }}</td>
                                <td>{{ $enroll->user->id_no }}</td>
                                <td><a href="{{ route('admin.users.edit', $enroll->user->id) }}" class="text-dark">{{ $enroll->user->name }}</a></td>
                                <td>{{ $enroll->branch->branch_name }}</td>
                                <td>{{ $enroll->start_date->format('d-m-Y') }}</td>
                                <td>{{ $enroll->category->category_name }}</td>
                                <td>{{ $enroll->type->type_name }} ({{ $enroll->type->duration }} Days)</td>
                                <td>{{ Carbon\Carbon::parse($enroll->slot->start_time)->format('h:i A') }}-{{ Carbon\Carbon::parse($enroll->slot->end_time)->format('h:i A') }} </td>
                                <td>
                                    <span class="badge rounded-pill {{ $enroll->status == 1 ? 'bg-success' : 'bg-danger' }}">{{ $enroll->status == 0 ? 'Pending' : ($enroll->status == 1 ? 'Approved' : 'Finished') }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.enroll.show', $enroll->id) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('admin.enroll_form.generate', $enroll->id) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Enrollment Form PDF"><i class="fa-regular fa-file"></i></a>
                                    @if (auth()->user()->hasRole([1, 2]))
                                        @if ($enroll->status == 0)
                                            <button class="btn btn-success btn-sm approve" data-id="{{ $enroll->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approve"><i class="fa-solid fa-check"></i></button>
                                        @endif
                                        @if ($enroll->status == 0)
                                            <button class="btn btn-danger btn-sm delete" data-id="{{ $enroll->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fa-solid fa-trash"></i></button>
                                        @endif
                                    @endif
                                </td>
                                @hasrole([1, 2, 3])
                                    <td>
                                        <button class="btn btn-info text-white btn-sm attendance-btn" data-id="{{ $enroll->id }}" {{ $enroll->status == '0' ? 'disabled' : '' }} data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Give Attendance">
                                            <i class="fas fa-plus-square"></i>
                                        </button>
                                    </td>
                                @endhasrole
                                @hasrole([1, 2])
                                    @if ($enroll->payment_status)
                                        @if ($enroll->paid == $enroll->payable_amount)
                                            <td class="fw-bold text-success">Paid <br> <a href="{{ route('admin.enroll_invoice.generate', $enroll->id) }}" class="mt-1 d-block site-text-primary text-white" style="font-size: 14px"><i class="fa-regular fa-file me-2"></i>Get Invoice</a></td>
                                        @else
                                            @if ($enroll->paid == 0)
                                                <td class="fw-bold text-danger">Not Paid</td>
                                            @else
                                                <td class="fw-bold site-text-secondary">Has Due (&#2547;{{ $enroll->payable_amount - $enroll->paid }}) <br> <a href="{{ route('admin.enroll_invoice.generate', $enroll->id) }}" class="mt-1 d-block site-text-primary text-white" style="font-size: 14px"><i class="fa-regular fa-file me-2"></i>Get Invoice</a></td>
                                            @endif
                                        @endif
                                    @else
                                        <td class="fw-bold text-danger">Not Paid</td>
                                    @endif
                                    <td>
                                        <button class="btn btn-info text-white btn-sm certificate-btn" value="{{ $enroll->status == '1' ? route('admin.certificate.view', $enroll->id) : '#' }}" {{ $enroll->status == '1' ? '' : 'disabled' }} data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Generate Certificate">
                                            <i class="far fa-credit-card"></i>
                                        </button>
                                    </td>
                                @endhasrole
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12">No enrollment found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Video course enrolls --}}
    <div class="card">
        <div class="card-header">
            <h5>Video Course Enrollments</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered align-middle text-center" style="width:100%">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Student Name</th>
                            <th>Course Title</th>
                            <th>Course Category</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($online_course_enrolls as $enroll)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $enroll->user->name }}</td>
                                <td>{{ $enroll->vid_course->course_title }}</td>
                                <td>{{ $enroll->vid_course->rel_to_course_cat->category_name }}</td>
                                <td>
                                    <span class="badge rounded-pill {{ $enroll->status == 1 ? 'bg-success' : 'bg-danger' }}">{{ $enroll->status == 0 ? 'Pending' : 'Approved' }}</span>
                                </td>
                                <td>
                                    @if (auth()->user()->hasRole([1, 2]))
                                        @if ($enroll->status == 0)
                                            <button class="btn btn-success btn-sm approve-online-course" data-id="{{ $enroll->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approve"><i class="fa-solid fa-check"></i></button>
                                        @endif
                                        @if ($enroll->status == 0)
                                            <button class="btn btn-danger btn-sm delete-online-course" data-id="{{ $enroll->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fa-solid fa-trash"></i></button>
                                        @else
                                            --
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10">No enrollment found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- attendance Modal -->
    <div class="modal fade" id="attendance" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="attendance-form">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 site-text-primary">Give Attendance</h1>
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
@endsection

@section('script')
    @if (auth()->user()->hasRole([1, 2, 3]))
        <script>
            $('.approve').click(function() {
                let id = $(this).data('id');
                let url = "{{ route('admin.enroll.approve', ':id') }}";
                url = url.replace(':id', id);
                warning(url);
            });

            $('.delete').click(function() {
                let id = $(this).data('id');
                let url = "{{ route('admin.enroll.delete', ':id') }}";
                url = url.replace(':id', id);
                delete_warning(url);
            });

            $('.approve-online-course').click(function() {
                let id = $(this).data('id');
                let url = "{{ route('admin.online_course_enroll.approve', ':id') }}";
                url = url.replace(':id', id);
                warning(url);
            });

            $('.delete-online-course').click(function() {
                let id = $(this).data('id');
                let url = "{{ route('admin.online_course_enroll.delete', ':id') }}";
                url = url.replace(':id', id);
                delete_warning(url);
            });

            $('.attendance-btn').click(function() {
                let id = $(this).data('id');
                let url = "{{ route('admin.attendance', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    method: 'get',
                    url: url,
                    success: function(response) {
                        if (response.error) {
                            Swal.fire(
                                'Sorry!',
                                response.error,
                                'error'
                            )
                        } else {
                            $('#attendance').modal('show');
                            $('#attendance .modal-body').html(response);
                        }
                    }
                })
            });

            $('#attendance-form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    method: 'POST',
                    url: "{{ route('admin.attendance.add') }}",
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            $('#attendance').modal('hide');
                            location.reload();
                        } else {
                            let errors = response.errors;
                            let errorsHtml = '<ul class="my-2 fw-bold text-danger">';
                            $.each(errors, function(key, value) {
                                errorsHtml += '<li>' + value + '</li>';
                            });
                            errorsHtml += '</ul>';
                            $('#attendance-form .error').html(errorsHtml);
                            $('#attendance-form .error').show();
                        }
                    }
                });
            });
        </script>

        <script>
            $('.certificate-btn').click(function() {
                let link = $(this).val();
                Swal.fire({
                    title: 'Are you sure to generate the certificate now?',
                    text: "Generate it if the student has completed the classes & passed the quizzes.",
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
        </script>
    @endif
@endsection
