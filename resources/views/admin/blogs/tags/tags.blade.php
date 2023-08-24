@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12 col-lg-8">
            <!-- tags -->
            <div class="card">
                <div class="card-header">
                    <h3 class="m-0 fs-5">Blog Tags</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table-striped datatable table-bordered table text-center align-middle">
                            <thead>
                                <tr>
                                    <th width="">SL</th>
                                    <th width="">Tag Name</th>
                                    <th width='14%'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tags as $key => $tag)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td><span class="badge site-bg-primary">{{ $tag->tag_name }}</span></td>
                                        <td>
                                            <button class="btn btn-primary btn-sm edit-tag" data-id="{{ $tag->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="fa-solid fa-pencil"></i></button>
                                            <button class="btn btn-danger btn-sm delete-tag" data-id="{{ $tag->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">No Tags Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="m-0 fs-5">Add New Tag</h3>
                </div>
                <div class="card-body">
                    <form id="add-tag-form">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Tag Name</label>
                            <input type="text" class="form-control @error('tag_name')is-invalid @enderror" name="tag_name" placeholder="Enter The Blog Category" value="{{ old('tag_name') }}" required>
                        </div>
                        <div class="error mb-3"></div>
                        <button class="mt-2 btn btn-primary btn-sm">Add Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- tag Edit Modal -->
    <div class="modal fade" id="editTag" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-3" style="width: 150%">
                <form id="edit-tag-form" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Edit tag</h1>
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
    @if (session('tagAddSuccess'))
        <script>
            Swal.fire(
                'Done',
                "{{ session('tagAddSuccess') }}",
                'success',
            )
        </script>
    @endif

    @if (session('tagUpdateSuccess'))
        <script>
            Swal.fire(
                'Done',
                "{{ session('tagUpdateSuccess') }}",
                'success',
            )
        </script>
    @endif

    @if (session('dltSuccess'))
        <script>
            Swal.fire(
                'Done',
                "{{ session('dltSuccess') }}",
                'success',
            )
        </script>
    @endif

    <script>
        $('#add-tag-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: "{{ route('admin.tag.add') }}",
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        // return response
                        location.reload();
                    } else {
                        let errors = response.errors;
                        let errorsHtml = '<ul class="m-0 mt-2 fw-light">';
                        $.each(errors, function(key, value) {
                            errorsHtml += '<li class= "fw-bold">' + value + '</li>';
                        });
                        errorsHtml += '</ul>';
                        $('#add-tag-form .error').html(errorsHtml);
                        $('#add-tag-form .error').show();

                    }
                }
            });
        });

        // edit tag
        $('.edit-tag').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.tag.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                method: 'get',
                url: url,
                success: function(response) {
                    $('#editTag').modal('show');
                    $('#editTag .modal-body').html(response);
                }
            })
        });

        $('#edit-tag-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: "{{ route('admin.tag.update') }}",
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
                        $('#edit-tag-form .error').html(errorsHtml);
                        $('#edit-tag-form .error').show();

                    }
                }
            });
        });


        $('.delete-tag').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.tag.delete', ':id') }}";
            url = url.replace(':id', id);
            delete_warning(url);
        });
    </script>
@endsection
