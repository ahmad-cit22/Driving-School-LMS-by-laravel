@extends('layouts.admin')
@section('content')
    <div class="row">
        {{-- Branches part --}}
        <div class="row">
            <div class="col-12 mt-3 mb-3">
                
                <div class="card p-3">
                    <div class="card-header">
                        <h3 class="m-0 fs-5">Branches Part</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <form class="mb-5" action="{{ route('admin.customize.contact.branch') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Branch Part Title</label>
                                        <input type="text" class="form-control @error('title')is-invalid @enderror" name="title" value="{{ $branch_part->title }}" placeholder="Enter Branch Part Title" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Branch Part Sub-title</label>
                                        <input type="text" class="form-control @error('subtitle')is-invalid @enderror" name="subtitle" value="{{ $branch_part->subtitle }}" placeholder="Enter Branch Part Sub-title" required>
                                        @error('subtitle')
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
      
        {{-- Contact page part --}}
        <div class="row">
            <div class="col-12 mt-3 mb-3">
                
                <div class="card p-3">
                    <div class="card-header">
                        <h3 class="m-0 fs-5">Contact Part</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <form class="mb-5" action="{{ route('admin.customize.contact.contact') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Contact Part Title</label>
                                        <input type="text" class="form-control @error('title')is-invalid @enderror" name="title" value="{{ $contact_part->title }}" placeholder="Enter Contact Part Title" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Contact Part Sub-title</label>
                                        <input type="text" class="form-control @error('subtitle')is-invalid @enderror" name="subtitle" value="{{ $contact_part->subtitle }}" placeholder="Enter Contact Part Sub-title" required>
                                        @error('subtitle')
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
