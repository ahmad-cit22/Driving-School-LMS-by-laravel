@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- Video Course List -->
            <div class="card">
                <div class="card-header">
                    <h3 class="m-0 fs-5">Video Course List</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="datatable table-striped table-bordered table text-center align-middle">
                            <thead>
                                <tr class="">
                                    <th class="text-center">Course Category</th>
                                    <th class="text-center">Course Type</th>
                                    <th class="text-center">Course Title</th>
                                    <th class="text-center">Class Videos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sl = 1;
                                @endphp
                                @forelse ($vid_courses as $key => $vid_course)
                                    @php
                                        $enroll = App\Models\Enroll::where('course_category', $vid_course->course_category)
                                            ->where('course_type', $vid_course->course_type)
                                            ->where('user_id', Auth::id())
                                            ->exists();
                                        
                                        $free_course_enroll = $online_enroll->where('vid_course_id', $vid_course->id)->exists();
                                    @endphp

                                    @if ($enroll || $free_course_enroll)
                                        <tr>
                                            <td>
                                                @php
                                                    if ($vid_course->course_category == '1') {
                                                        echo 'Car (Manual)';
                                                    } elseif ($vid_course->course_category == '2') {
                                                        echo 'Car (Auto)';
                                                    } elseif ($vid_course->course_category == '3') {
                                                        echo 'Bike';
                                                    } else {
                                                        echo 'Scooter';
                                                    }
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    if ($vid_course->course_type == '0') {
                                                        echo 'Short';
                                                    } else {
                                                        echo 'Long';
                                                    }
                                                    
                                                @endphp
                                            </td>
                                            <td>{{ $vid_course->course_title }}</td>
                                            <td>
                                                <a href="{{ route('admin.student.vid_courses.videos', $vid_course->id) }}" class="btn btn-success btn-sm text-white">Class Videos</a>
                                            </td>
                                        </tr>
                                    @endif
                                    @php
                                        $sl += 1;
                                    @endphp
                                @empty
                                    <tr>
                                        <td colspan="11">No Courses Found</td>
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
        <div class="col text-center">
            <a href="{{ route('courses.view') }}" class="btn site-bg-primary text-white">Browse Courses</a>
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

    @if (session('notEnrolled'))
        <script>
            Swal.fire(
                'Sorry!',
                "{{ session('notEnrolled') }}",
                'error'
            )
        </script>
    @endif

    @if (session('notApproved'))
        <script>
            Swal.fire(
                'Sorry!',
                "{{ session('notApproved') }}",
                'error'
            )
        </script>
    @endif

    <script>
        //edit course
        $('.edit-course').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.vid_course.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                method: 'get',
                url: url,
                success: function(response) {
                    $('#editCourse').modal('show');
                    $('#editCourse .modal-body').html(response);
                }
            })
        });

        $('#edit-course-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: "{{ route('admin.vid_course.update') }}",
                data: $(this).serialize(),
                success: function(response) {
                    window.location.reload();
                }
            });
        });

        $('.delete-course').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.vid_course.delete', ':id') }}";
            url = url.replace(':id', id);
            delete_warning(url);
        });
    </script>
@endsection
