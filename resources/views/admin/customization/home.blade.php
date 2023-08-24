@extends('layouts.admin')
@section('content')
    <div class="row">

        <div class="row">
            <div class="mx-auto col-10 mt-3 mb-3">
                {{-- Banner part --}}
                <div class="card p-3">
                    <div class="card-header">
                        <h3 class="m-0 fs-5">Update Banner Part</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.customize.home.banner') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Logo Image</label>
                                <input type="file" class="form-control @error('logo_image')is-invalid @enderror" name="logo_image">
                                @error('logo_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Banner Image</label>
                                <input type="file" class="form-control @error('banner_image')is-invalid @enderror" name="banner_image">
                                @error('banner_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Banner Sub-title</label>
                                <input type="text" class="form-control @error('subtitle')is-invalid @enderror" name="subtitle" value="{{ $banner_part->subtitle }}" placeholder="Enter Banner Sub-title" required>
                                @error('subtitle')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Banner Title</label>
                                <input type="text" class="form-control @error('title')is-invalid @enderror" name="title" value="{{ $banner_part->title }}" placeholder="Enter Banner Title" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Banner Bottom Text</label>
                                <input type="text" class="form-control @error('bottom_text')is-invalid @enderror" name="bottom_text" value="{{ $banner_part->bottom_text }}" placeholder="Enter Banner Bottom Text" required>
                                @error('bottom_text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Button One Name</label>
                                <input type="text" class="form-control @error('button_one_name')is-invalid @enderror" name="button_one_name" value="{{ $banner_part->button_one_name }}" placeholder="Enter Button One Name" required>
                                @error('button_one_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Button Two Name</label>
                                <input type="text" class="form-control @error('button_two_name')is-invalid @enderror" name="button_two_name" value="{{ $banner_part->button_two_name }}" placeholder="Enter Button Two Name" required>
                                @error('button_two_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Button One Link</label>
                                <input type="text" class="form-control @error('button_one_link')is-invalid @enderror" name="button_one_link" value="{{ $banner_part->button_one_link }}" placeholder="Enter Button One Link (If you want to change the default link)">
                                @error('button_one_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Button Two Link</label>
                                <input type="text" class="form-control @error('button_two_link')is-invalid @enderror" name="button_two_link" value="{{ $banner_part->button_two_link }}" placeholder="Enter Button Two Link (If you want to change the default link)">
                                @error('button_two_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button class="btn btn-primary btn-sm mt-2 fs-6">Update Now</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mt-3 mb-3">
                {{-- Feature part --}}
                <div class="card p-3">
                    <div class="card-header">
                        <h3 class="m-0 fs-5">Feature Part</h3>
                    </div>
                    <div class="card-body">
                        <div class="card">
                            <div class="card-body">
                                <form class="mb-5" action="{{ route('admin.customize.home.feature') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Feature Part Title</label>
                                        <input type="text" class="form-control @error('title')is-invalid @enderror" name="title" value="{{ $feature_part->title }}" placeholder="Enter Feature Part Title" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Feature Part Sub-title</label>
                                        <input type="text" class="form-control @error('subtitle')is-invalid @enderror" name="subtitle" value="{{ $feature_part->subtitle }}" placeholder="Enter Feature Part Sub-title" required>
                                        @error('subtitle')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button class="btn btn-primary btn-sm mt-2 fs-6">Update Now</button>
                                </form>
                            </div>
                        </div>

                        {{-- Feature List --}}
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <h5>Feature List</h4>
                                    <div class="table-responsive">
                                        <table class="px-2 table datatable table-striped table-bordered text-center align-middle">
                                            <thead class="">
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Title</th>
                                                    <th>Text</th>
                                                    <th class="text-center">Icon</th>
                                                    <th class="text-center">Sorting Priority</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="">
                                                @forelse ($features as $key => $feature)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $feature->title }}</td>
                                                        <td>{{ $feature->text }}</td>
                                                        <td class="text-center">
                                                            {{ $feature->icon }}
                                                        </td>
                                                        <td class="text-center">{{ $feature->priority }}</td>
                                                        <td class="d-flex gap-1">
                                                            <button class="btn btn-info text-white btn-sm edit-feature" data-id="{{ $feature->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="fa-solid fa-pencil" style=""></i> </button>
                                                            <button class="btn btn-danger btn-sm delete-feature" data-id="{{ $feature->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fa-solid fa-trash" style=""></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="11">No Features Found</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                            </div>
                            <div class="col-12">
                                <form action="{{ route('admin.add.new.feature') }}" method="POST">
                                    @csrf
                                    <h4 class="mt-3 mb-3 fs-5">Add a New Feature</h4>
                                    <div class="mb-3">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control @error('title')is-invalid @enderror" name="title" value="{{ old('title') }}" placeholder="Enter Title" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Fetaure Text</label>
                                        <input type="text" class="form-control @error('text')is-invalid @enderror" name="text" value="{{ old('text') }}" placeholder="Enter Fetaure Text" required>
                                        @error('text')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Icon</label>
                                        <input type="text" class="form-control @error('icon')is-invalid @enderror" name="icon" value="{{ old('icon') }}" placeholder="Enter Icon" required>
                                        @error('icon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Sorting Priority</label>
                                        <input type="number" class="form-control @error('priority')is-invalid @enderror" name="priority" value="{{ old('priority') }}" placeholder="Enter Priority Number" required>
                                        @error('priority')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button class="btn btn-primary btn-sm mt-2 fs-6">Add Now</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- Counter facts part --}}
        <div class="row">
            <div class="col-12 mt-3 mb-3">
                <div class="card p-3">
                    <div class="card-header">
                        <h3 class="m-0 fs-5">Counter Facts Part</h3>
                    </div>
                    <div class="card-body">
                        <div class="row gap-4">
                            <div class="col-12">
                                <h4>Counter Facts</h4>
                                <div class="table-responsive">
                                    <table class="px-2 table datatable table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Amount</th>
                                                <th>Text</th>
                                                <th class="text-center">Icon</th>
                                                <th class="text-center">Sorting Priority</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($counters as $key => $counter)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $counter->amount }}</td>
                                                    <td>{{ $counter->text }}</td>
                                                    <td class="text-center">
                                                        {{ $counter->icon }}
                                                    </td>
                                                    <td class="text-center">{{ $counter->priority }}</td>
                                                    <td class="d-flex gap-1">
                                                        <button class="btn btn-info text-white btn-sm edit-counter" data-id="{{ $counter->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="fa-solid fa-pencil" style=""></i> </button>
                                                        <button class="btn btn-danger btn-sm delete-counter" data-id="{{ $counter->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fa-solid fa-trash" style=""></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="11">No Counter Facts Found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-10 mx-auto">
                                <form class="mt-3 mt-lg-0" action="{{ route('admin.add.new.counter') }}" method="POST">
                                    @csrf
                                    <h4 class="mb-3 fs-5">Add a New Counter</h4>
                                    <div class="mb-3">
                                        <label class="form-label">Amount</label>
                                        <input type="number" class="form-control @error('amount')is-invalid @enderror" name="amountCounter" value="{{ old('amountCounter') }}" placeholder="Enter The Amount" required>
                                        @error('amountCounter')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Counter Text</label>
                                        <input type="text" class="form-control @error('text')is-invalid @enderror" name="textCounter" value="{{ old('textCounter') }}" placeholder="Enter Counter Text" required>
                                        @error('textCounter')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Icon</label>
                                        <input type="text" class="form-control @error('icon')is-invalid @enderror" name="iconCounter" value="{{ old('iconCounter') }}" placeholder="Enter Icon" required>
                                        @error('iconCounter')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Sorting Priority</label>
                                        <input type="number" class="form-control @error('priority')is-invalid @enderror" name="priorityCounter" value="{{ old('priorityCounter') }}" placeholder="Enter Priority Number" required>
                                        @error('priorityCounter')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button class="btn btn-primary btn-sm mt-2 fs-6">Add Now</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- training process video part --}}
        <div class="row">
            <div class="col-12 mt-3 mb-3">
                <div class="card p-3">
                    <div class="card-header">
                        <h3 class="m-0 fs-5">Training Process Video</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <form action="{{ route('admin.add.training.video') }}" method="POST">
                                    @csrf
                                    {{-- <h4 class="mb-3 fs-5">Add New Video</h4> --}}
                                    <div class="mb-3">
                                        <label class="form-label">Update Title</label>
                                        <input type="text" class="form-control @error('titleVideo')is-invalid @enderror" name="titleVideo" value="{{ $video->title }}" placeholder="Enter The Title of the Video" required>
                                        @error('titleVideo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Update Video Link</label>
                                        <input type="text" class="form-control @error('videoLink')is-invalid @enderror" name="videoLink" value="{{ $video->link }}" placeholder="Enter the Video Link" required>
                                        @error('videoLink')
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

        {{-- Gallery part --}}
        <div class="row my-3">
            <div class="col-12 col-lg-8">
                <div class="card p-3">
                    <div class="card-header">
                        <h5>Gallery Images</h5>
                    </div>
                    <div class="card-body">
                        <table class="datatable table-striped table-bordered table text-center align-middle">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Image Class</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($gallery_images as $key => $gallery_image)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $gallery_image->image_class }}</td>
                                        <td><img class="" src="{{ asset('assets/frontend/img/gallery/' . $gallery_image->image) }}" alt="{{ $gallery_image->image }}" width="100"></td>
                                        <td width="12%">
                                            <button class="btn btn-primary btn-sm edit-gallery-image" data-id="{{ $gallery_image->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="fa-solid fa-pencil"></i></button>
                                            <button class="btn btn-danger btn-sm delete-gallery-image" data-id="{{ $gallery_image->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">No Images Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card p-3">
                    <div class="card-header">
                        <h6>Add New Image</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.customize.gallery_image.add') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Image Class</label>
                                <select name="image_class" class="form-select select2 @error('image_class')is-invalid @enderror" required>
                                    <option value=""> -- Select a class -- </option>
                                    <option value="vehicles">vehicles</option>
                                    <option value="classrooms">classrooms</option>
                                    <option value="students">students</option>
                                    <option value="exams">exams</option>
                                </select>
                                @error('image_class')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Upload Image</label>
                                <input type="file" class="form-control" id="gallery_image" name="gallery_image" required>
                                @error('gallery_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button class="mt-2 btn btn-primary btn-sm">Add Now</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        {{-- FAQ part --}}
        <div class="row my-3">
            <div class="col-12 col-lg-8">
                <div class="card p-3">
                    <div class="card-header">
                        <h5>FAQ Questions</h5>
                    </div>
                    <div class="card-body">
                        <table class="datatable table-striped table-bordered table text-center align-middle">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Question</th>
                                    <th>Answer</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($faq_questions as $key => $faq_question)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $faq_question->question }}</td>
                                        <td>{{ $faq_question->answer }}</td>
                                        <td width="12%">
                                            <button class="btn btn-primary btn-sm edit-question" data-id="{{ $faq_question->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="fa-solid fa-pencil"></i></button>
                                            <button class="btn btn-danger btn-sm delete-question" data-id="{{ $faq_question->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">No Questions Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card p-3">
                    <div class="card-header">
                        <h6>Add New Question</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.customize.faq.add') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Question</label>
                                <input type="text" class="form-control @error('question')is-invalid @enderror" name="question" value="{{ old('question') }}" placeholder="Enter the FAQ Question." required>
                                @error('question')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Answer</label>
                                <textarea class="form-control @error('answer')is-invalid @enderror" name="answer" placeholder="Enter the answer." cols="30" rows="6" required>{{ old('answer') }}</textarea>
                                @error('answer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button class="mt-2 btn btn-primary btn-sm">Add Now</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card p-3">
                        <div class="card-header">
                            <h3 class="m-0 fs-5">FAQ Image Update</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <form action="{{ route('admin.customize.faq.image.add') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">FAQ Image</label>
                                            <div class="my-2">
                                                <img class="faq_image_preview" id="faq_image_preview" src="{{ asset('assets/frontend/img/faq/' . $faq_image->image) }}" alt="{{ $faq_image->image }}" width="200">
                                            </div>
                                            <input type="file" class="form-control" id="faq_image" name="faq_image" onchange="document.getElementById('faq_image_preview').src = window.URL.createObjectURL(this.files[0])" required>
                                            @error('faq_image')
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

        </div>


        {{-- Modals --}}
        <!-- feature Edit Modal -->
        <div class="modal fade" id="editFeature" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="edit-feature-form">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Edit Feature</h1>
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

        <!-- counter Edit Modal -->
        <div class="modal fade" id="editCounter" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="edit-counter-form">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Edit Counter Fact</h1>
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

        <!-- question Edit Modal -->
        <div class="modal fade" id="editQuestion" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="edit-question-form" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Edit Question</h1>
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

        <!-- gallery image Edit Modal -->
        <div class="modal fade" id="editGalleryImage" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="edit-gallery-image-form" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Edit Gallery Image</h1>
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

            //training process video

            $('.delete-video').click(function() {
                let id = $(this).data('id');
                let url = "{{ route('admin.training.video.delete', ':id') }}";
                url = url.replace(':id', id);
                // alert(url);
                delete_warning(url);
            });

            //faq part edit & delete
            $('.edit-gallery-image').click(function() {
                let id = $(this).data('id');
                let url = "{{ route('admin.customize.gallery_image.edit', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    method: 'get',
                    url: url,
                    success: function(response) {
                        $('#editGalleryImage').modal('show');
                        $('#editGalleryImage .modal-body').html(response);
                    }
                })
            });

            $('#edit-gallery-image-form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    method: 'POST',
                    url: "{{ route('admin.customize.gallery_image.update') }}",
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            $('#editGalleryImage').modal('hide');
                            location.reload();
                        } else {
                            let errors = response.errors;
                            let errorsHtml = '<ul class="m-0 mt-2 fw-light">';
                            $.each(errors, function(key, value) {
                                errorsHtml += '<li>' + value + '</li>';
                            });
                            errorsHtml += '</ul>';
                            $('#edit-gallery-image-form .error').html(errorsHtml);
                            $('#edit-gallery-image-form .error').show();

                        }
                    }
                });
            });

            $('.delete-gallery-image').click(function() {
                let id = $(this).data('id');
                let url = "{{ route('admin.customize.gallery_image.delete', ':id') }}";
                url = url.replace(':id', id);
                delete_warning(url);
            });

            //faq part edit & delete
            $('.edit-question').click(function() {
                let id = $(this).data('id');
                let url = "{{ route('admin.customize.faq.edit', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    method: 'get',
                    url: url,
                    success: function(response) {
                        $('#editQuestion').modal('show');
                        $('#editQuestion .modal-body').html(response);
                    }
                })
            });

            $('#edit-question-form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    method: 'POST',
                    url: "{{ route('admin.customize.faq.update') }}",
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            $('#editQuestion').modal('hide');
                            location.reload();
                        } else {
                            let errors = response.errors;
                            let errorsHtml = '<ul class="m-0 mt-2 fw-light">';
                            $.each(errors, function(key, value) {
                                errorsHtml += '<li>' + value + '</li>';
                            });
                            errorsHtml += '</ul>';
                            $('#edit-question-form .error').html(errorsHtml);
                            $('#edit-question-form .error').show();

                        }
                    }
                });
            });

            $('.delete-question').click(function() {
                let id = $(this).data('id');
                let url = "{{ route('admin.customize.faq.delete', ':id') }}";
                url = url.replace(':id', id);
                delete_warning(url);
            });
        </script>
    @endsection
