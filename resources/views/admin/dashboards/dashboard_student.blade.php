@extends('layouts.admin')
@section('content')
    {{-- overall report --}}
    <div class="row mb-5">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <tr class="fs-6">
                        <th>Student ID: {{ $student->id_no }}</th>
                        <th>Student Name: {{ $student->name }}</th>
                    </tr>
                    <tr>
                        <td>Courses Enrolled: {{ $enrolls_count }}</td>
                        <td>Courses Completed: {{ $courses_completed }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col">
            <div class="mb-3">
                <h4 class="text-center">Enrolled Courses</h4>
            </div>
            <div class="table-responsive">
                <table class="table datatable table-striped table-bordered text-center align-middle">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Course Category</th>
                            <th>Course Type</th>
                            <th>Course Slot</th>
                            <th>Payment Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- offline_course_enrolls --}}
                        @foreach ($enrolls as $key => $enroll)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $enroll->category->category_name }} <span class="badge site-bg-primary">Offline</span></td>
                                <td>{{ $enroll->type->type_name }} ({{ $enroll->type->duration }} Days)</td>
                                <td>{{ Carbon\Carbon::parse($enroll->slot->start_time)->format('h:i A') }} - {{ Carbon\Carbon::parse($enroll->slot->end_time)->format('h:i A') }}</td>
                                @if ($enroll->payment_status)
                                    <td class="{{ $enroll->paid == $enroll->payable_amount ? 'text-success' : 'text-danger' }}"> {{ $enroll->paid == $enroll->payable_amount ? 'Paid' : 'Not Paid (Due Amount: BDT ' . $enroll->payable_amount - $enroll->paid . ')' }} <br>
                                        @if ($enroll->paid != $enroll->payable_amount)
                                            {{-- <a href="{{ route('enroll.due.pay', $enroll->id) }}" class="mt-2 d-inline-block btn btn-sm site-bg-primary text-white">Pay Dues</a> --}}
                                            <button class="due-pay mt-2 d-inline-block btn btn-sm site-bg-primary text-white" data-id="{{ $enroll->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Due Pay">Pay Dues</button>
                                        @endif
                                    </td>
                                @else
                                    <td class="fw-bold text-danger">{{ 'Not Paid (Due Amount: BDT ' . $enroll->payable_amount . ')' }} <br>
                                        @if ($enroll->paid != $enroll->payable_amount)
                                            {{-- <a href="{{ route('enroll.due.pay', $enroll->id) }}" class="mt-2 d-inline-block btn btn-sm site-bg-primary text-white">Pay Dues</a> --}}
                                            <button class="due-pay mt-2 d-inline-block btn btn-sm site-bg-primary text-white" data-id="{{ $enroll->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Due Pay">Pay Dues</button>
                                        @endif
                                    </td>
                                @endif
                                <td> <a href="{{ route('admin.view.details', $enroll->id) }}" class="btn btn-sm site-bg-primary text-white">View Details</a> </td>
                            </tr>
                        @endforeach

                        {{-- online_course_enrolls --}}
                        @foreach ($online_course_enrolls as $key => $enroll)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $enroll->vid_course->rel_to_course_cat->category_name }} <span class="badge site-bg-secondary">Online</span> </td>
                                <td>{{ $enroll->vid_course->rel_to_course_type->type_name }}</td>
                                <td> -- </td>
                                <td class=""> -- </td>
                                <td> <a href="{{ route('admin.student.vid_courses.videos', $enroll->vid_course->id) }}" class="btn btn-sm site-bg-primary text-white">View Details</a> </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col text-center">
            <a href="{{ route('courses.view') }}" class="btn site-bg-primary text-white">Browse More Courses</a>
        </div>
    </div>

    <!-- Due Pay Modal -->
    <div class="modal fade" id="duePay" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="width: 600px">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Pay Dues</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3>...</h3>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @if (session('notApproved'))
        <script>
            Swal.fire(
                'Sorry!',
                "{{ session('notApproved') }}",
                'error',
            )
        </script>
    @endif

    <script>
        //due pay
        $('.due-pay').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('enroll.due.pay', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                method: 'get',
                url: url,
                success: function(response) {
                    $('#duePay').modal('show');
                    $('#duePay .modal-body').html(response);
                }
            })
        });
    </script>
@endsection
