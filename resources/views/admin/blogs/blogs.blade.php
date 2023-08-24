@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Blogs -->
            <div class="card">
                <div class="card-header">
                    <h3 class="m-0 fs-5">Blogs</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table-striped datatable table-bordered table text-center align-middle">
                            <thead>
                                <tr>
                                    <th width="">SL</th>
                                    <th width="">Category</th>
                                    <th width="">Blog Title</th>
                                    <th width="">Blog Banner Image</th>
                                    <th width="">Blog Post</th>
                                    <th width="">Blog Tags</th>
                                    <th width='9%'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($blogs as $key => $blog)
                                    @php
                                        if ($blog->blog_banner_image != null) {
                                            $blog_img = $blog->blog_banner_image;
                                        } else {
                                            $blog_img = 'def-image.jpg';
                                        }
                                        
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $blog->blog_category }}</td>
                                        <td>{{ $blog->blog_title }}</td>
                                        <td><img class="" src="{{ asset('assets/frontend/img/blog/' . $blog_img) }}" alt="{{ $blog_img }}" width="150" /></td>
                                        <td>
                                            <button class="btn btn-primary btn-sm view-blog" data-id="{{ $blog->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View Blog"><i class="fa-solid fa-note"></i></button>
                                        </td>
                                        <td>
                                            @forelse ($blog->blog_tags as $blog_tag)
                                                <span class="badge site-bg-primary">{{ $blog_tag->tag->tag_name }}</span>
                                            @empty
                                                <span> -- </span>
                                            @endforelse
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm edit-blog" data-id="{{ $blog->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="fa-solid fa-pencil"></i></button>
                                            <button class="btn btn-danger btn-sm delete-blog" data-id="{{ $blog->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">No Blogs Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row mt-20">
        <div class="col-12 col-lg-10 mx-auto">
            <div class="card p-3">
                <div class="card-header">
                    <h3 class="m-0 fs-5">Add New Blog</h3>
                </div>
                <div class="card-body">
                    <form id="add-blog-form">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <input type="text" class="form-control @error('blog_category')is-invalid @enderror" name="blog_category" placeholder="Enter The Blog Category" value="{{ old('blog_category') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Blog Title</label>
                            <input type="text" class="form-control @error('blog_title')is-invalid @enderror" name="blog_title" placeholder="Enter The Blog Title" value="{{ old('blog_title') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Blog Banner Image</label>
                            <input type="file" class="form-control @error('blog_banner_image')is-invalid @enderror" name="blog_banner_image">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Blog Post</label>
                            <textarea name="blog_post" id="blog_post" cols="30" rows="25" @error('blog_post')is-invalid @enderror></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea class="form-control" name="meta_description" id="meta_description" placeholder="Enter the meta description that will be placed inside the meta tag." cols="30" rows="6" @error('meta_description')is-invalid @enderror></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Add Tags</label>
                            <select class="form-select select2" id="multiple-select-field" data-placeholder="Choose Tags For Blog" multiple name="blog_tags[]">
                                <option value="0"></option>
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->tag_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="error mb-3"></div>
                        <button class="mt-2 btn btn-primary btn-sm">Add Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Blog View Model -->
    <div class="modal fade" id="viewBlog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-3" style="width: 150%">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">View Blog</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3>...</h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Blog Edit Modal -->
    <div class="modal fade" id="editBlog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-3" style="width: 160%">
                <form id="edit-blog-form" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Edit Blog</h1>
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
    @if (session('blogAddSuccess'))
        <script>
            Swal.fire(
                'Done',
                "{{ session('blogAddSuccess') }}",
                'success',
            )
        </script>
    @endif

    @if (session('blogUpdateSuccess'))
        <script>
            Swal.fire(
                'Done',
                "{{ session('blogUpdateSuccess') }}",
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
        $('#add-blog-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: "{{ route('admin.blog.add') }}",
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
                        $('#add-blog-form .error').html(errorsHtml);
                        $('#add-blog-form .error').show();

                    }
                }
            });
        });

        // view-blog
        $('.view-blog').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.blog.view', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                method: 'get',
                url: url,
                success: function(response) {
                    $('#viewBlog').modal('show');
                    $('#viewBlog .modal-body').html(response);
                }
            })
        });

        // edit blog
        $('.edit-blog').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.blog.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                method: 'get',
                url: url,
                success: function(response) {
                    $('#editBlog').modal('show');
                    $('#editBlog .modal-body').html(response);
                    $('#edit_blog_post').summernote();
                    $('#multiple-select-field2').select2({
                        theme: "bootstrap-5",
                        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                        placeholder: $(this).data('placeholder'),
                        closeOnSelect: false,
                        allowClear: true,
                    });
                }
            })
        });

        $('#edit-blog-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: "{{ route('admin.blog.update') }}",
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
                        $('#edit-blog-form .error').html(errorsHtml);
                        $('#edit-blog-form .error').show();

                    }
                }
            });
        });


        $('.delete-blog').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.blog.delete', ':id') }}";
            url = url.replace(':id', id);
            delete_warning(url);
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#blog_post').summernote();
        });

    </script>
    <script>
        $('#multiple-select-field').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
            allowClear: true,
        });
    </script>
@endsection
