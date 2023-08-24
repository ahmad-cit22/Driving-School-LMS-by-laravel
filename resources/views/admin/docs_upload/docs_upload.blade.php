@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12 col-lg-12">
            <!-- Docs List -->
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="m-0 fs-5">Documents for Students</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive table">
                        <table class="table table-striped datatable table-bordered text-center align-middle">
                            <thead>
                                <tr>
                                    <th width="">SL</th>
                                    <th width="">Course Name</th>
                                    <th width="">File Name</th>
                                    <th width="">File Size</th>
                                    <th width="">Note</th>
                                    <th width="">Uploaded At</th>
                                    <th width='9%'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($course_docs as $key => $doc)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $doc->course->rel_to_course_cat->category_name . ' - ' . $doc->course->rel_to_course_type->type_name }}</td>
                                        <td>{{ $doc->name }}</td>
                                        <td>{{ $doc->size }}</td>
                                        <td>{{ $doc->note ? $doc->note : '--' }}</td>
                                        <td>{{ Carbon\Carbon::parse($doc->created_at)->format('d-m-Y') }}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm edit-doc" data-id="{{ $doc->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="fa-solid fa-pencil"></i></button>
                                            <button class="btn btn-danger btn-sm delete-doc" data-id="{{ $doc->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">No Entry Found</td>
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
        <div class="col-12 col-md-7 col-lg-6 mx-auto">
            <div class="card p-2">
                <div class="card-header">
                    <h3 class="m-0 fs-5">Add New Document</h3>
                </div>
                <div class="card-body">
                    <form id="add-docs-form">
                        {{-- <form action="{{ route('admin.docs.store') }}" method="post" enctype="multipart/form-data"> --}}
                        @csrf
                        <div class="form-group mt-3">
                            <label class="form-label">Select Course</label>
                            <select name="course_id" class="form-select select2 @error('course_id')is-invalid @enderror">
                                <option value="0">-- Choose an Option --</option>
                                @foreach ($courses as $key => $course)
                                    <option value="{{ $course->id }}" {{ $course->id == old('available_for') ? 'selected' : '' }}>{{ $course->rel_to_course_cat->category_name }} - {{ $course->rel_to_course_type->type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Upload File</label>
                            <input type="file" name="file" class="form-control" accept=".jpg,.jpeg,.bmp,.gif,.doc,.docx,.csv,.rtf,.ppt,.xlsx,.xls,.txt,.pdf,.zip">
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Add Note (If Needed)</label>
                            <textarea class="form-control @error('note')is-invalid @enderror" name="note" placeholder="Enter the note here." cols="30" rows="6">{{ old('note') }}</textarea>
                        </div>

                        <button class="w-100 btn btn-lg btn-primary mt-4" type="submit">Add Now</button>
                        <div class="error"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Doc Edit Model -->
    <div class="modal fade" id="editDoc" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="edit-docs-form">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Edit File</h1>
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
    <script>
        $('#add-docs-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: "{{ route('admin.docs.store') }}",
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
                        $('#add-docs-form .error').html(errorsHtml);
                        $('#add-docs-form .error').show();

                    }
                }
            });
        });

        // edit doc
        $('.edit-doc').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.docs.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                method: 'get',
                url: url,
                success: function(response) {
                    if (!response.error) {
                        $('#editDoc').modal('show');
                        $('#editDoc .modal-body').html(response);
                    } else {
                        Swal.fire(
                            'Sorry',
                            "Unauthorized access!",
                            'error',
                        )
                    }
                }
            })
        });

        $('#edit-docs-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: "{{ route('admin.docs.update') }}",
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
                        $('#edit-docs-form .error').html(errorsHtml);
                        $('#edit-docs-form .error').show();

                    }
                }
            });
        });

        $('.delete-doc').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.docs.delete', ':id') }}";
            url = url.replace(':id', id);
            delete_warning(url);
        });
    </script>
@endsection
