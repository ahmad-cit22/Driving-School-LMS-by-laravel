@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="m-0 fs-5">Class Videos of The Course - {{ $vid_course->course_title }}</h3>
                </div>
                <div class="card-body" style="">
                    <div class="table-responsive">
                        <table class="datatable table-striped table-bordered table text-center align-middle">
                            <thead>
                                <tr>
                                    <th>Class No.</th>
                                    <th>Title</th>
                                    <th>Video</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($videos as $video)
                                    <tr>
                                        <td>{{ $video->class_no }}</td>
                                        <td>{{ $video->video_title }}</td>
                                        <td> <a class="fw-bold site-text-primary text-decoration-underline" href="{{ $video->video_link }}" target="_blank" rel="">Click to Watch</a> </td>
                                        <td> <button class="btn btn-info text-white btn-sm edit-video" data-id="{{ $video->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="fa-solid fa-pencil"></i> </button>
                                            <button class="btn btn-danger btn-sm delete-video" data-id="{{ $video->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11">No Videos Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        {{-- Videos Add Model --}}
        <div class="col-12 col-md-4">
            <div class="card p-3">
                <div class="card-header">
                    <h5 class="m-0">Add New Video For This Course</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.vid_courses.videos.store', $vid_course->id) }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">Class No.</label>
                            <input type="number" class="form-control @error('class_no')is-invalid @enderror" name="class_no" value="{{ old('class_no') }}" placeholder="Enter Class No." required>
                            @error('class_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Video Title</label>
                            <input type="text" class="form-control @error('video_title')is-invalid @enderror" name="video_title" value="{{ old('video_title') }}" placeholder="Enter Video Title" required>
                            @error('video_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Video Link</label>
                            <input type="text" class="form-control @error('video_link')is-invalid @enderror" name="video_link" value="{{ old('video_link') }}" placeholder="Enter The Link of Class Video" required>
                            @error('video_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn btn-primary btn-sm mt-2 fs-6">Add Now</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- class video Edit Model -->
    <div class="row">
        <div class="col-md-12">
            <div class="modal fade" id="editVideo" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="edit-video-form">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Edit Class Video</h1>
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
        let table = new DataTable('.datatable2');
    </script>
    <script>
        // class video
        $('.edit-video').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.video.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                method: 'get',
                url: url,
                success: function(response) {
                    $('#editVideo').modal('show');
                    $('#editVideo .modal-body').html(response);
                }
            })
        });

        $('#edit-video-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: "{{ route('admin.video.update') }}",
                data: $(this).serialize(),
                success: function(response) {
                    window.location.reload();
                }
            });
        });

        $('.delete-video').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.video.delete', ':id') }}";
            url = url.replace(':id', id);
            delete_warning(url);
        });
    </script>
@endsection
