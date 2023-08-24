@csrf
<input type="hidden" name="id" value="{{ $coupon->id }}">

<div class="mb-3">
    <label class="form-label">Coupon Code</label>
    <input type="text" class="form-control @error('coupon_code')is-invalid @enderror" name="coupon_code" placeholder="Example: 'NEWYEAR23'" value="{{ $coupon->coupon_code }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Coupon Type</label>
    <select name="coupon_type" id="coupon-type" class="form-select select2 @error('coupon_type')is-invalid @enderror">
        <option value="0">-- Select A Coupon Type --</option>
        <option value="1" {{ 1 == $coupon->coupon_type ? 'selected' : '' }}>Solid</option>
        <option value="2" {{ 2 == $coupon->coupon_type ? 'selected' : '' }}>Percentage</option>
    </select>
</div>
<div class="mb-3">
    <label class="form-label">Discount Amount</label>
    <input type="number" class="form-control @error('discount_amount')is-invalid @enderror" name="discount_amount" placeholder="Enter the amount of discount." value="{{ $coupon->discount_amount }}" required>
</div>
<div class="mb-3" id="discount-limit">
    <label class="form-label">Max Discount Limit</label>
    <input type="number" class="form-control @error('limit')is-invalid @enderror" name="limit" placeholder="Enter the max limit of discount in BDT." value="{{ $coupon->limit }}">
</div>
<div class="mb-3">
    <label class="form-label">Available For</label>
    <select name="available_for" class="form-select select2 @error('available_for')is-invalid @enderror">
        <option value="0">-- Choose An Option --</option>
        <option value="1" {{ 1 == $coupon->available_for ? 'selected' : '' }}>All Courses</option>
        @foreach ($courses as $key => $course)
            <option value="{{ $course->id + 1 }}" {{ $course->id + 1 == $coupon->available_for ? 'selected' : '' }}>{{ $course->rel_to_course_cat->category_name }} - {{ $course->rel_to_course_type->type_name }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label class="form-label">For Branch</label>
    <select name="branch_id" class="form-select select2 @error('branch_id')is-invalid @enderror">
        <option value="0">-- Choose an Option --</option>
        <option value="1" {{ 1 == $coupon->branch_id ? 'selected' : '' }}>All Branches</option>
        @foreach ($branches as $key => $branch)
            <option value="{{ $branch->id + 1 }}" {{ $branch->id + 1 == $coupon->branch_id ? 'selected' : '' }}>{{ $branch->branch_name }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label class="form-label">Valid Till</label>
    <input type="date" class="form-control @error('validity')is-invalid @enderror" name="validity" placeholder="Enter the amount of discount." value="{{ $coupon->validity }}">
</div>
<div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select select2 @error('status')is-invalid @enderror">
        <option value="0">-- Choose Status --</option>
        <option value="1" {{ 1 == $coupon->status ? 'selected' : '' }}>Inactive</option>
        <option value="2" {{ 2 == $coupon->status ? 'selected' : '' }}>Active</option>
    </select>
</div>
<div class="error mb-3"></div>
