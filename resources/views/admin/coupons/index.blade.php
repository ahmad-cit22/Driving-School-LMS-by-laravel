@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12 col-lg-12">
            <!-- coupons -->
            <div class="card">
                <div class="card-header">
                    <h3 class="m-0 fs-5">Coupon List</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table-striped datatable table-bordered table text-center align-middle">
                            <thead>
                                <tr>
                                    <th width="">SL</th>
                                    <th width="">Coupon Code</th>
                                    <th width="">Coupon Type</th>
                                    <th width="">Discount Amount</th>
                                    <th width="">Max Discount Limit</th>
                                    <th width="">Available For</th>
                                    <th width="">For Branch</th>
                                    <th width="">Valid Till</th>
                                    <th width="">Status</th>
                                    <th width='9%'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($coupons as $key => $coupon)
                                    @php
                                        //availability for course
                                        if ($coupon->available_for == '1') {
                                            $availability = 'All Courses';
                                        } else {
                                            $availability = 'N/A';
                                            if (App\Models\Course::where('id', $coupon->available_for - 1)->exists()) {
                                                $availability = App\Models\Course::find($coupon->available_for - 1)->rel_to_course_cat->category_name . ' - ' . App\Models\Course::find($coupon->available_for - 1)->rel_to_course_type->type_name;
                                            }
                                        }
                                        
                                        //availability for branch
                                        if ($coupon->branch_id == '1') {
                                            $for_branch = 'All Branches';
                                        } else {
                                            $for_branch = App\Models\Branch::find($coupon->branch_id - 1)->branch_name;
                                        }
                                        
                                        $validity = Carbon\Carbon::now()->diffInDays($coupon->validity, false);
                                        
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $coupon->coupon_code }}</td>
                                        <td>{{ $coupon->coupon_type == '1' ? 'Solid' : 'Percentage' }}</td>
                                        <td>{{ $coupon->discount_amount }} {{ $coupon->coupon_type == '1' ? 'BDT' : '%' }}</td>
                                        <td>{{ $coupon->limit == null ? '--' : $coupon->limit . ' BDT' }}</td>
                                        <td class="{{ $availability == 'N/A' ? 'text-danger' : '' }}">{{ $availability }}</td>
                                        <td>{{ $for_branch }}</td>
                                        <td>
                                            @if ($coupon->validity != null)
                                                @if ($validity >= 0)
                                                    {{ $validity . ' Days Left' }}
                                                @else
                                                    Expired
                                                @endif
                                            @else
                                                --
                                            @endif
                                        </td>
                                        <td>{{ $coupon->status == '1' ? 'Inactive' : 'Active' }}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm edit-coupon" data-id="{{ $coupon->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="fa-solid fa-pencil"></i></button>
                                            <button class="btn btn-danger btn-sm delete-coupon" data-id="{{ $coupon->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10">No Coupons Found</td>
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
            <div class="card p-3">
                <div class="card-header">
                    <h3 class="m-0 fs-5">Add New Coupon</h3>
                </div>
                <div class="card-body">
                    <form id="add-coupon-form">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Coupon Code</label>
                            <input type="text" class="form-control @error('coupon_code')is-invalid @enderror" name="coupon_code" placeholder="Example: 'NEWYEAR23'" value="{{ old('coupon_code') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Coupon Type</label>
                            <select name="coupon_type" id="coupon-type" class="form-select select2 @error('coupon_type')is-invalid @enderror">
                                <option value="0">-- Choose a Type --</option>
                                <option value="1" {{ 1 == old('coupon_type') ? 'selected' : '' }}>Solid</option>
                                <option value="2" {{ 2 == old('coupon_type') ? 'selected' : '' }}>Percentage</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Discount Amount</label>
                            <input type="number" class="form-control @error('discount_amount')is-invalid @enderror" name="discount_amount" placeholder="Enter the amount of discount." value="{{ old('discount_amount') }}" required>
                        </div>
                        <div class="mb-3" id="discount-limit">
                            <label class="form-label">Max Discount Limit</label>
                            <input type="number" class="form-control @error('limit')is-invalid @enderror" name="limit" placeholder="Enter the max limit of discount in BDT." value="{{ old('limit') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Available For (Category)</label>
                            <select name="available_for" class="form-select select2 @error('available_for')is-invalid @enderror">
                                <option value="0">-- Choose an Option --</option>
                                <option value="1" {{ 1 == old('available_for') ? 'selected' : '' }}>All Courses</option>
                                @foreach ($courses as $key => $course)
                                    <option value="{{ $course->id + 1 }}" {{ $course->id + 1 == old('available_for') ? 'selected' : '' }}>{{ $course->rel_to_course_cat->category_name }} - {{ $course->rel_to_course_type->type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">For Branch</label>
                            <select name="branch_id" class="form-select select2 @error('branch_id')is-invalid @enderror">
                                <option value="0">-- Choose an Option --</option>
                                <option value="1" {{ 1 == old('branch_id') ? 'selected' : '' }}>All Branches</option>
                                @foreach ($branches as $key => $branch)
                                    <option value="{{ $branch->id + 1 }}" {{ $branch->id + 1 == old('branch_id') ? 'selected' : '' }}>{{ $branch->branch_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Valid Till</label>
                            <input type="date" class="form-control @error('validity')is-invalid @enderror" name="validity" placeholder="Enter the amount of discount." value="{{ old('validity') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select select2 @error('status')is-invalid @enderror">
                                <option value="0">-- Choose Status --</option>
                                <option value="1" {{ 1 == old('status') ? 'selected' : '' }}>Inactive</option>
                                <option value="2" {{ 2 == old('status') ? 'selected' : '' }}>Active</option>
                            </select>
                        </div>
                        <div class="error mb-3"></div>
                        <button class="mt-2 btn btn-primary btn-sm">Add Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- editCoupon Modal -->
    <div class="modal fade" id="editCoupon" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="edit-coupon-form">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Edit Coupon</h1>
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
        $('#discount-limit').hide();

        $('#coupon-type').change(function() {
            let type = $('#coupon-type').val();
            if (type == 2) {
                $('#discount-limit').show();
            } else {
                $('#discount-limit').hide();
            }
        })

        $('#add-coupon-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: "{{ route('admin.coupon.add') }}",
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
                        $('#add-coupon-form .error').html(errorsHtml);
                        $('#add-coupon-form .error').show();
                    }
                }
            });
        });

        // edit coupon
        $('.edit-coupon').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.coupon.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                method: 'get',
                url: url,
                success: function(response) {
                    $('#editCoupon').modal('show');
                    $('#editCoupon .modal-body').html(response);
                }
            })
        });

        $('#edit-coupon-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: "{{ route('admin.coupon.update') }}",
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
                        $('#edit-coupon-form .error').html(errorsHtml);
                        $('#edit-coupon-form .error').show();

                    }
                }
            });
        });


        $('.delete-coupon').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.coupon.delete', ':id') }}";
            url = url.replace(':id', id);
            delete_warning(url);
        });
    </script>
@endsection
