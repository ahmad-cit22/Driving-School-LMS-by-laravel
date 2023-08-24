@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-8">
            @hasrole(1)
                <!-- course category -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="m-0 fs-5">Course Category</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table-striped table-bordered table text-center align-middle">
                                <tr>
                                    <th width="40%">Course Category</th>
                                    <th width="40%">Category Thumbnail</th>
                                    <th>Action</th>
                                </tr>
                                @forelse ($course_categories as $course_category)
                                    <tr>
                                        <td>{{ $course_category->category_name }}</td>
                                        <td><img class="" src="{{ asset('assets/frontend/images/category/' . $course_category->image) }}" alt="{{ $course_category->image }}" width="100"></td>
                                        <td>
                                            <button class="btn btn-primary btn-sm edit-category" data-id="{{ $course_category->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="fa-solid fa-pencil"></i></button>
                                            <button class="btn btn-danger btn-sm delete-category" data-id="{{ $course_category->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">No Course Category Found</td>
                                    </tr>
                                @endforelse
                            </table>
                        </div>
                    </div>
                </div>
                <!-- course type -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="m-0 fs-5">Course Type</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table-striped table-bordered table text-center align-middle">
                                <tr>
                                    <th width="40%">Course Type</th>
                                    <th width="20%">Duration</th>
                                    <th width="20%">Max Duration</th>
                                    <th>Action</th>
                                </tr>
                                @forelse ($course_types as $course_type)
                                    <tr>
                                        <td>{{ $course_type->type_name }}</td>
                                        <td>{{ $course_type->duration }} {{ $course_type->duration <= 1 ? 'Day' : 'Days' }}</td>
                                        <td>{{ $course_type->max_duration }} {{ $course_type->max_duration <= 1 ? 'Day' : 'Days' }}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm edit-type" data-id="{{ $course_type->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="fa-solid fa-pencil"></i></button>
                                            <button class="btn btn-danger btn-sm delete-type" data-id="{{ $course_type->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">No Course Type Found</td>
                                    </tr>
                                @endforelse
                            </table>
                        </div>
                    </div>
                </div>
            @endhasrole
            <!-- course slot -->
            <div class="card">
                <div class="card-header">
                    <h3 class="m-0 fs-5">Course Slot / Batch</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table-striped table-bordered table text-center align-middle">
                            <tr>
                                <th width="20%">Start Time</th>
                                <th width="20%">End Time</th>
                                <th>Branch</th>
                                <th>Type</th>
                                <th width="15%">Action</th>
                            </tr>
                            @forelse ($course_slots as $course_slot)
                                <tr>
                                    <td>{{ Carbon\Carbon::parse($course_slot->start_time)->format('h:i A') }}</td>
                                    <td>{{ Carbon\Carbon::parse($course_slot->end_time)->format('h:i A') }}</td>
                                    <td>{{ $course_slot->branch->branch_name }}</td>
                                    <td>{{ $course_slot->type == 1 ? 'Practical' : 'Theory' }}</td>
                                    <td>
                                        @if (Auth::user()->hasRole(1) || $course_slot->branch->id == Auth::user()->branch_id)
                                            <button class="btn btn-danger btn-sm delete-slot" data-id="{{ $course_slot->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fa-solid fa-trash"></i></button>
                                        @else
                                            <button class="btn btn-danger btn-sm delete-slot" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete" disabled><i class="fa-solid fa-trash"></i></button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No Course Slot Found</td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>

            @hasrole(1)
                <!-- branch vehicle capability -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="m-0 fs-5">Branch Vehicle Capability</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table-striped table-bordered table text-center align-middle">
                                <tr>
                                    <th>Branch Name</th>
                                    @foreach ($course_categories as $course_category)
                                        <th>{{ $course_category->category_name }}</th>
                                    @endforeach
                                    <th>Action</th>
                                </tr>
                                @forelse ($branches as $branch)
                                    <tr>
                                        <td>{{ $branch->branch_name }}</td>
                                        @foreach ($course_categories as $course_category)
                                            <td>{{ $branch_capabilities->where('branch_id', $branch->id)->where('category_id', $course_category->id)->first()->available_vehical ?? '-' }}</td>
                                        @endforeach
                                        <td>
                                            <button class="btn btn-primary btn-sm edit-capability" data-id="{{ $branch->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="fa-solid fa-pencil"></i></button>
                                            <button class="btn btn-danger btn-sm delete-capability" data-id="{{ $branch->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">No Branch Vehical Capability Found</td>
                                    </tr>
                                @endforelse
                            </table>
                        </div>
                    </div>
                </div>
            @endhasrole
        </div>

        <div class="col-md-4">
            @hasrole(1)
                {{-- Add Course Category --}}
                <div class="card">
                    <div class="card-header">
                        <h3 class="m-0 fs-5">Add Course Category</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.courses.category.add') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label">Category Name</label>
                                <input type="text" class="form-control @error('category_name')is-invalid @enderror" name="category_name" value="{{ old('category_name') }}" placeholder="Enter Category Name">
                                @error('category_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Category Thumbnail</label>
                                <input type="file" class="form-control @error('image')is-invalid @enderror" name="image">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button class="mt-2 btn btn-primary btn-sm">Add Now</button>
                        </form>
                    </div>
                </div>

                {{-- Add Course Type --}}
                <div class="card">
                    <div class="card-header">
                        <h3 class="m-0 fs-5">Add Course Type</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.courses.type.add') }}" method="POST">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label">Type Name</label>
                                <input type="text" class="form-control @error('type_name')is-invalid @enderror" name="type_name" value="{{ old('type_name') }}" placeholder="Enter Type Name">
                                @error('type_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Duration</label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('duration')is-invalid @enderror" name="duration" value="{{ old('duration') }}" placeholder="Enter Duration" min="1">
                                    <span class="input-group-text">Days</span>
                                    @error('duration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Max Duration</label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('max_duration')is-invalid @enderror" name="max_duration" value="{{ old('max_duration') }}" placeholder="Enter Max Duration" min="1">
                                    <span class="input-group-text">Days</span>
                                    @error('max_duration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button class="mt-2 btn btn-primary btn-sm">Add Now</button>
                        </form>
                    </div>
                </div>
            @endhasrole

            {{-- Add Course Slot --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="m-0 fs-5">Add New Slot / Batch</h3>
                </div>
                <div class="card-body">
                    <form id="slot-add">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">Start Time</label>
                            <input type="time" class="form-control" name="start_time" id="start_time" value="10:00">
                            <div class="error"></div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">End Time</label>
                            <input type="time" class="form-control" name="end_time" id="end_time" value="11:00">
                            <div class="error"></div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Class Type</label>
                            <select name="type" id="type" class="select2 form-select" required>
                                <option></option>
                                <option value="1">Practical</option>
                                <option value="2">Theory</option>
                            </select>
                            <div class="error"></div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Branch</label>
                            <select name="branch_id_s" id="branch_id_s" class="select2 form-select" required>
                                <option></option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                @endforeach
                            </select>
                            <div class="error"></div>
                        </div>
                        <div class="mb-2 slot-day">
                            <label class="form-label">Day</label>
                            <select name="day" id="day" class="select2 form-select">
                                <option></option>
                            </select>
                            <div class="error"></div>
                        </div>
                        <button class="mt-2 btn btn-primary btn-sm">Add Now</button>
                    </form>
                </div>
            </div>

            @hasrole(1)
                {{-- Add Branch Capability --}}
                <div class="card">
                    <div class="card-header">
                        <h3 class="m-0 fs-5">Add Branch Capability</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.courses.capability.add') }}" method="POST">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label">Branch</label>
                                <select name="branch_id" class="form-select select2 @error('branch_id')is-invalid @enderror">
                                    <option></option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ $branch->id == old('branch_id') ? 'selected' : '' }}>{{ $branch->branch_name }}</option>
                                    @endforeach
                                </select>
                                @error('branch_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Course Category</label>
                                <select name="category_id" class="form-select select2 @error('category_id')is-invalid @enderror">
                                    <option></option>
                                    @foreach ($course_categories as $course_category)
                                        <option value="{{ $course_category->id }}" {{ $course_category->id == old('category_id') ? 'selected' : '' }}>{{ $course_category->category_name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Available Vehical</label>
                                <input name="available_vehical" type="number" class="form-control @error('available_vehical')is-invalid @enderror" value="{{ old('available_vehical') }}" placeholder="Enter Quantity">
                                @error('available_vehical')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button class="mt-2 btn btn-primary btn-sm">Add Now</button>
                        </form>
                    </div>
                </div>
            @endhasrole
        </div>
    </div>

    @hasrole(1)
        <!-- Category Edit Modal -->
        <div class="modal fade" id="editCategory" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="edit-category-form" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Edit Course Category</h1>
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

        <!-- Type Edit Modal -->
        <div class="modal fade" id="editType" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="edit-type-form">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Edit Course Type</h1>
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
    @endhasrole

    <!-- Slot Edit Modal -->
    <div class="modal fade" id="editSlot" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="edit-slot-form">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Edit Course Slot</h1>
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

    @hasrole(1)
        <!-- Capability Edit Modal -->
        <div class="modal fade" id="editCapability" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="edit-capability-form">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Edit Course Slot</h1>
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
    @endhasrole
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

        /*
                                                            form .error ul {
                                                                list-style-type: none;
                                                            } */
    </style>
@endsection

@section('script')
    <script>
        //course category
        $('.edit-category').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.courses.category.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                method: 'get',
                url: url,
                success: function(response) {
                    $('#editCategory').modal('show');
                    $('#editCategory .modal-body').html(response);
                }
            })
        });

        $('#edit-category-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: "{{ route('admin.courses.category.update') }}",
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        $('#editCategory').modal('hide');
                        location.reload();
                    } else {
                        let errors = response.errors;
                        let errorsHtml = '<ul class="m-0 mt-2 fw-light">';
                        $.each(errors, function(key, value) {
                            errorsHtml += '<li>' + value + '</li>';
                        });
                        errorsHtml += '</ul>';
                        $('#edit-category-form .error').html(errorsHtml);
                        $('#edit-category-form .error').show();

                    }
                }
            });
        });

        $('.delete-category').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.courses.category.delete', ':id') }}";
            url = url.replace(':id', id);
            delete_warning(url);
        });

        //course type
        $('.edit-type').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.courses.type.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                method: 'get',
                url: url,
                success: function(response) {
                    $('#editType').modal('show');
                    $('#editType .modal-body').html(response);
                }
            })
        });

        $('#edit-type-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: "{{ route('admin.courses.type.update') }}",
                data: $(this).serialize(),
                success: function(response) {
                    window.location.reload();
                }
            });
        });

        $('.delete-type').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.courses.type.delete', ':id') }}";
            url = url.replace(':id', id);
            delete_warning(url);
        });

        //course slot
        $('#type').change(function() {
            let type = $(this).val();
            if (type == 2) {
                $('.slot-day').css('display', 'block');
                if ($('#branch_id_s').val()) {
                    get_day($('#branch_id_s').val())
                }
            } else {
                $('.slot-day').css('display', 'none');
            }
        });

        $('#branch_id_s').change(function() {
            if ($('#type').val() == 2) {
                let id = $(this).val();
                get_day(id);
            }
        });

        function get_day(id) {
            let url = "{{ route('admin.courses.slot.get.day', ':id') }}";
            $.ajax({
                method: 'get',
                url: url.replace(':id', id),
                success: function(response) {
                    $('#day').html(response);
                }
            });
        }

        $('#slot-add').submit(function(e) {
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: "{{ route('admin.courses.slot.add') }}",
                data: $(this).serialize(),
                success: function(response) {
                    $('.error').html('');
                    $('input').removeClass('is-invalid');
                    $('select').removeClass('is-invalid');
                    if (response.success) {
                        window.location.reload();
                    } else {
                        let errors = response.errors;
                        $.each(errors, function(key, value) {
                            let field = '#' + key;
                            $(field).addClass('is-invalid');
                            $(field).siblings('.error').html(value);
                            $(field).siblings('.error').css('display', 'block');
                        });
                    }
                }
            });
        });

        $('.delete-slot').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.courses.slot.delete', ':id') }}";
            url = url.replace(':id', id);
            delete_warning(url);
        });

        //branch capability
        $('.edit-capability').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.courses.capability.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                method: 'get',
                url: url,
                success: function(response) {
                    $('#editCapability').modal('show');
                    $('#editCapability .modal-body').html(response);
                }
            })
        });

        $('#edit-capability-form').submit(function(e) {
            e.preventDefault();
            if ($(this).serialize()) {
                $.ajax({
                    method: 'POST',
                    url: "{{ route('admin.courses.capability.update') }}",
                    data: $(this).serialize(),
                    success: function(response) {
                        window.location.reload();
                    }
                });
            } else {
                $('#editCapability').modal('hide');
            }
        });

        $('.delete-capability').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.courses.capability.delete', ':id') }}";
            url = url.replace(':id', id);
            delete_warning(url);
        });
    </script>
@endsection
