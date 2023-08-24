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
                                <tr>
                                    <th>SL</th>
                                    <th width="">Course Thumbnail</th>
                                    <th>Course Category</th>
                                    <th>Course Type</th>
                                    <th>Course Title</th>
                                    <th>Class Videos</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($vid_courses as $key => $vid_course)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td><img class="" src="{{ asset('assets/frontend/img/courses/' . $vid_course->image) }}" alt="" width="100"></td>
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
                                            <a href="{{ route('admin.vid_courses.videos', $vid_course->id) }}" class="btn btn-success btn-sm text-white">Class Videos</a>
                                        </td>
                                        <td>
                                            <button class="btn btn-info text-white btn-sm edit-course" data-id="{{ $vid_course->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="fa-solid fa-pencil"></i> </button>
                                            <button class="btn btn-danger btn-sm delete-course" data-id="{{ $vid_course->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
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

        {{-- Video Course Add Model --}}
        <div class="col-12 col-md-7 mt-3 mb-5 mx-auto">
            <div class="card p-3">
                <div class="card-header">
                    <h3 class="m-0 fs-5">Add a New Video Course</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.vid_courses.add') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Course Thumbnail</label>
                            <input type="file" class="form-control @error('image')is-invalid @enderror" name="image">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
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
                        <div class="mb-3">
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
                        <div class="mb-3">
                            <label class="form-label">Course Title</label>
                            <input type="text" class="form-control @error('course_title')is-invalid @enderror" name="course_title" value="{{ old('course_title') }}" placeholder="Enter Course Title" required>
                            @error('course_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea class="form-control" name="meta_description" id="meta_description" placeholder="Enter the meta description that will be placed inside the head tag." cols="30" rows="6" @error('meta_description')is-invalid @enderror></textarea>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}
                        <button class="btn btn-primary btn-sm mt-2 fs-6">Add Now</button>
                    </form>
                </div>
            </div>

        </div>

        <!-- course Edit Model -->
        <div class="modal fade" id="editCourse" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="edit-course-form" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Edit Course</h1>
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
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            $('#editCourse').modal('hide');
                            location.reload();
                        } else {
                            let errors = response.errors;
                            let errorsHtml = '<ul class="m-0 mt-2 fw-light">';
                            $.each(errors, function(key, value) {
                                errorsHtml += '<li>' + value + '</li>';
                            });
                            errorsHtml += '</ul>';
                            $('#edit-course-form .error').html(errorsHtml);
                            $('#edit-course-form .error').show();

                        }
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
