@extends('layouts.admin')
@section('top-btn')
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addBranch">
        <i class="fa-solid fa-plus"></i> Add Branch</button>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table-striped table-bordered table text-center align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>Serial</th>
                            <th>Branch Name</th>
                            <th>Branch Address</th>
                            <th>Email</th>
                            <th>Phone No</th>
                            <th>Theory Class</th>
                            <th>Signature</th>
                            <th>Action</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($branches as $branch)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $branch->branch_name }}</td>
                                <td>{{ $branch->branch_address }}</td>
                                <td>{{ $branch->email }}</td>
                                <td>{{ $branch->phone }}</td>
                                <td>
                                    @foreach ($branch->theory_class as $class)
                                        <span class="badge rounded-pill bg-primary">{{ $class->days->day }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @if ($branch->branch_manager_signature)
                                        <img class="manager-signature" src="{{ asset("uploads/signature/$branch->branch_manager_signature") }}">
                                        <button type="button" class="btn btn-warning btn-sm edit-signature" data-id="{{ $branch->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit Signature"><i class="far fa-pencil"></i></button>
                                    @else
                                        <button type="button" class="btn btn-primary btn-sm add-signature" data-id="{{ $branch->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Upload Signature"><i class="far fa-plus"></i></button>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.branches.edit', $branch->id) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="fa-solid fa-edit"></i></a>
                                </td>
                                <td>
                                    <form action="{{ route('admin.branch.status.update', $branch->id) }}" method="POST">
                                        @csrf
                                        <select name="status" id="status-change{{ $branch->id }}" onchange="changeStatus(this, {{ $branch->id }})" class="form-select select2 @error('status')is-invalid @enderror" required>
                                            <option value="0" {{ $branch->status == 0 ? 'selected' : '' }}>Inactive</option>
                                            <option value="1" {{ $branch->status == 1 ? 'selected' : '' }}>Active</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No Branch Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Branch Modal -->
    <div class="modal fade" id="addBranch" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="add-branch" method="POST" action="{{ route('admin.branches.store') }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Branch</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="form-errors"></div>
                        @csrf
                        <div class="mb-3">
                            <label for="branch-name" class="form-label">Branch Name</label>
                            <input type="text" class="form-control" id="branch-name" name="branch_name" value="{{ old('branch_name') }}">
                        </div>
                        <div class="mb-3">
                            <label for="branch-address" class="form-label">Branch Address</label>
                            <textarea class="form-control" name="branch_address" id="branch-address">{{ old('branch_address') }}</textarea>
                            <div class="mb-3">
                                <label for="email" class="form-label">Branch Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Branch Phone No.</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Theory Class (Day)</label>
                                <select name="theory_classes[]" id="theory_class" class="form-select select2 {{ $errors->has('theory_classes') ? 'is-invalid' : '' }}" multiple>
                                    <option></option>
                                    @foreach ($days as $day)
                                        <option value="{{ $day->id }}">{{ $day->day }}</option>
                                    @endforeach
                                </select>
                                @error('theory_classes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Now</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Upload Signature Modal -->
    <div class="modal fade" id="upload-signature" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="upload-signature-form" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Upload Signature</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h3>..226655.</h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Signature Modal -->
    {{-- <div class="modal fade" id="edit-signature" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="edit-signature-form" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Edit Signature</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h3>...</h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
@endsection

@section('script')
    <script>
        $('#add-branch').submit(function(e) {
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: "{{ route('admin.branches.store') }}",
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#addBranch').modal('hide');
                        location.reload();
                    } else {
                        let errors = response.errors;
                        let errorsHtml = '<div class="alert alert-danger alert-dismissible fade show"><ul class="m-0">';

                        $.each(errors, function(key, value) {
                            errorsHtml += '<li>' + value + '</li>';
                        });
                        errorsHtml += '</ul><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';

                        $('#form-errors').html(errorsHtml);
                    }
                }
            });
        });

        $('.add-signature').click(function() {
            let branch_id = $(this).data('id');
            let url = "{{ route('admin.branches.upload.signature.modal', ':id') }}";
            url = url.replace(':id', branch_id);
            // alert(url);
            $.ajax({
                method: 'get',
                url: url,
                success: function(response) {
                    // alert(response);
                    $('#upload-signature').modal('show');
                    $('#upload-signature .modal-body').html(response);
                }
            })
        });

        $('#upload-signature-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: "{{ route('admin.branches.upload.signature') }}",
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        $('#upload-signature').modal('hide');
                        location.reload();
                    } else {
                        let errors = response.errors;
                        let errorsHtml = '<ul class="m-0 mt-2 fw-light">';

                        $.each(errors, function(key, value) {
                            errorsHtml += '<li>' + value + '</li>';
                        });
                        errorsHtml += '</ul>';

                        $('#upload-signature-form .error').html(errorsHtml);
                    }
                }
            });
        });


        $('.edit-signature').click(function() {
            let branch_id = $(this).data('id');
            let url = "{{ route('admin.branches.edit.signature.modal', ':id') }}";
            url = url.replace(':id', branch_id);
            $.ajax({
                method: 'get',
                url: url,
                success: function(response) {
                    $('#edit-signature').modal('show');
                    $('#edit-signature .modal-body').html(response);
                }
            })
        });

        $('#edit-signature-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: "{{ route('admin.branches.edit.signature') }}",
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        $('#edit-signature').modal('hide');
                        location.reload();
                    } else {
                        let errors = response.errors;
                        let errorsHtml = '<ul class="m-0 mt-2 fw-light">';

                        $.each(errors, function(key, value) {
                            errorsHtml += '<li>' + value + '</li>';
                        });
                        errorsHtml += '</ul>';

                        $('#edit-signature-form .error').html(errorsHtml);
                    }
                }
            });
        });
    </script>

    <script>
        function changeStatus(selectElement, id) {
            let formElement = selectElement.parentNode;
            
            Swal.fire({
                title: 'Are you sure?',
                text: "Change the status only if you are sure about it!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, proceed.'
            }).then((result) => {
                if (result.isConfirmed) {
                    formElement.submit();
                }
            });
        }
    </script>
@endsection

@section('style')
    <style>
        .error {
            color: #ea868f;
            font-size: 14px;
        }

        .manager-signature {
            max-height: 40px;
            object-fit: contain;
        }
    </style>
@endsection
