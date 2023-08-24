@extends('layouts.admin')
@section('content')
    <div class="row">
        {{-- About part --}}
        <div class="row">
            <div class="col-12 mt-3 mb-3">

                <div class="card p-3">
                    <div class="card-header">
                        <h3 class="m-0 fs-5">About Us Part</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <form class="mb-5" action="{{ route('admin.customize.about.about') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">About Part Video Link</label>
                                    <input type="text" class="form-control @error('about_video_link')is-invalid @enderror" name="about_video_link" value="{{ $about_part->about_video_link }}" placeholder="Enter The Embed Video Link" required>
                                    @error('about_video_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">About Part Text</label>
                                    <input type="text" class="form-control @error('about_text')is-invalid @enderror" name="about_text" value="{{ $about_part->about_text }}" placeholder="Enter The About Text" required>
                                    @error('about_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button class="btn btn-primary btn-sm mt-2 fs-6">Update Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- directors speech part --}}
        <div class="row">
            <div class="col-12 mt-3 mb-3">

                <div class="card p-3">
                    <div class="card-header">
                        <h3 class="m-0 fs-5">Director's Speech Part</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <form class="mb-5" action="{{ route('admin.customize.about.director_speech') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Director's Name</label>
                                    <input type="text" class="form-control @error('director_name')is-invalid @enderror" name="director_name" value="{{ $director_speech_part->director_name }}" placeholder="Enter The Name of the Director" required>
                                    @error('director_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Director's Photo</label>
                                    <img class="director_image_preview" id="director_image_preview" src="{{ asset('assets/frontend/img/about/' . $director_speech_part->director_image) }}" alt="{{ $director_speech_part->director_image }}">
                                    <input type="file" class="form-control" id="director_image" name="director_image" onchange="document.getElementById('director_image_preview').src = window.URL.createObjectURL(this.files[0])">
                                    @error('director_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Director's Speech</label>
                                    <textarea class="form-control @error('director_speech')is-invalid @enderror" name="director_speech" placeholder="Enter The Speech" required cols="30" rows="10">{{ $director_speech_part->director_speech }}</textarea>
                                    {{-- <input type="text" class="form-control @error('director_speech')is-invalid @enderror" name="director_speech" value="{{ $director_speech_part->director_speech }}" placeholder="Enter The Speech" required> --}}
                                    @error('director_speech')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button class="btn btn-primary btn-sm mt-2 fs-6">Update Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- certified_by part --}}
        <div class="row my-3">
            <div class="col-12 col-lg-7">
                <div class="card p-3">
                    <div class="card-header">
                        <h5>Certified By Part</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table-striped table-bordered table text-center align-middle">
                                <tr>
                                    <th>SL</th>
                                    <th>Certified By</th>
                                    <th>Certificate Image</th>
                                    <th>Action</th>
                                </tr>
                                @forelse ($certified_by_parts as $key => $certified_by_part)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $certified_by_part->certified_by }}</td>
                                        <td><img class="" src="{{ asset('assets/frontend/img/footer/' . $certified_by_part->certificate_image) }}" alt="{{ $certified_by_part->certificate_image }}" width="100"></td>
                                        <td>
                                            <button class="btn btn-primary btn-sm edit-certificate" data-id="{{ $certified_by_part->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="fa-solid fa-pencil"></i></button>
                                            <button class="btn btn-danger btn-sm delete-certificate" data-id="{{ $certified_by_part->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">No Certificates Found</td>
                                    </tr>
                                @endforelse
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="card p-3">
                    <div class="card-header">
                        <h6>Add New Certificate</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.customize.certified_by.add') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Certified By</label>
                                <input type="text" class="form-control @error('certified_by')is-invalid @enderror" name="certified_by" value="{{ old('certified_by') }}" placeholder="Enter the certifier institution name.">
                                @error('certified_by')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Certificate Image</label>
                                <input type="file" class="form-control @error('certificate_image')is-invalid @enderror" name="certificate_image">
                                @error('certificate_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button class="mt-2 btn btn-primary btn-sm">Add Now</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- Category Edit Model -->
    <div class="modal fade" id="editCertificate" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="edit-certificate-form" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Edit Certificate</h1>
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

        .director_image_preview {
            display: block;
            padding: 10px 0px;
            margin-bottom: 5px;
            width: 200px;
            height: 115px;
            object-fit: contain;
        }
    </style>
@endsection

@section('script')
    <script>
        //Certificate by part edit & delete
        $('.edit-certificate').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.customize.certified_by.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                method: 'get',
                url: url,
                success: function(response) {
                    $('#editCertificate').modal('show');
                    $('#editCertificate .modal-body').html(response);
                }
            })
        });

        $('#edit-certificate-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: "{{ route('admin.customize.certified_by.update') }}",
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        $('#editCertificate').modal('hide');
                        location.reload();
                    } else {
                        let errors = response.errors;
                        let errorsHtml = '<ul class="m-0 mt-2 fw-light">';
                        $.each(errors, function(key, value) {
                            errorsHtml += '<li>' + value + '</li>';
                        });
                        errorsHtml += '</ul>';
                        $('#edit-certificate-form .error').html(errorsHtml);
                        $('#edit-certificate-form .error').show();

                    }
                }
            });
        });

        $('.delete-certificate').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.customize.certified_by.delete', ':id') }}";
            url = url.replace(':id', id);
            delete_warning(url);
        });
    </script>

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

    @if (session('updateSuccess'))
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: '{{ session('updateSuccess') }}',
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
    @if (session('counterAddSuccess'))
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: '{{ session('counterAddSuccess') }}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    <script>
        //feature
        $('.edit-feature').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.feature.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                method: 'get',
                url: url,
                success: function(response) {
                    $('#editFeature').modal('show');
                    $('#editFeature .modal-body').html(response);
                }
            })
        });

        $('#edit-feature-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: "{{ route('admin.feature.update') }}",
                data: $(this).serialize(),
                success: function(response) {
                    window.location.reload();
                }
            });
        });

        $('.delete-feature').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.feature.delete', ':id') }}";
            url = url.replace(':id', id);
            delete_warning(url);
        });

        //counter
        $('.edit-counter').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.counter.edit', ':id') }}";
            url = url.replace(':id', id);
            // alert(id)
            $.ajax({
                method: 'get',
                url: url,
                success: function(response) {
                    // window.location.reload();
                    $('#editCounter').modal('show');
                    $('#editCounter .modal-body').html(response);
                }
            })
        });

        $('#edit-counter-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: "{{ route('admin.counter.update') }}",
                data: $(this).serialize(),
                success: function(response) {
                    window.location.reload();
                }
            });
        });

        $('.delete-counter').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.counter.delete', ':id') }}";
            url = url.replace(':id', id);
            delete_warning(url);
        });

        $('.delete-video').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.training.video.delete', ':id') }}";
            url = url.replace(':id', id);
            // alert(url);
            delete_warning(url);
        });
    </script>
@endsection
