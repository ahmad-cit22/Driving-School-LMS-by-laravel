@csrf
<input type="hidden" name="id" value="{{ $course->id }}">

<div class="mb-3">
    <label class="form-label">Course Category</label>
    <select name="category_id" class="form-select select2 @error('category_id')is-invalid @enderror" required>
        <option>Select an Option</option>
        @foreach ($course_categories as $course_category)
            <option value="{{ $course_category->id }}" {{ $course_category->id == $course->category_id ? 'selected' : '' }}>{{ $course_category->category_name }}</option>
        @endforeach
    </select>
    @error('category_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Course Type</label>
    <select name="type_id" class="form-select select2 @error('type_id')is-invalid @enderror" required>
        <option>Select an Option</option>
        @foreach ($course_types as $course_type)
            <option value="{{ $course_type->id }}" {{ $course_type->id == $course->type_id ? 'selected' : '' }}>{{ $course_type->type_name }}</option>
        @endforeach
    </select>
    @error('type_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <div class="img">
        <img class="mt-1" id="thumb-preview" src="{{ asset('assets/frontend/img/courses/' . $course->image) }}" alt="" width="100">
    </div>
    <label class="form-label">Course Thumbnail</label>
    <input type="file" class="form-control @error('image')is-invalid @enderror" name="image" onchange="document.getElementById('thumb-preview').src = window.URL.createObjectURL(this.files[0])" accept=".jpg, .png, jpeg, .gif, .webp">
    @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Course Fee</label>
    <input type="number" class="form-control @error('price')is-invalid @enderror" name="price" value="{{ $course->price }}" placeholder="Enter The Course Fee (BDT)" required>
    @error('price')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Discount (in Percentage)</label>
    <input type="number" class="form-control @error('discount')is-invalid @enderror" name="discount" value="{{ $course->discount }}" placeholder="Enter Discount in Percentage (If Available)">
    @error('discount')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label class="form-label">Course Details</label>
    <textarea name="course_details" id="edit_course_details" cols="30" rows="15" @error('course_details')is-invalid @enderror>{{ $course->course_details }}</textarea>

    @error('refund_policy')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label class="form-label">Sorting Priority</label>
    <input type="number" class="form-control @error('priority')is-invalid @enderror" name="priority" value="{{ $course->priority }}" placeholder="Enter The Priority Num" required>
    @error('priority')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label class="form-label">Meta Description</label>
    <textarea class="form-control" name="meta_description" id="meta_description" placeholder="Enter the meta description that will be placed inside the head tag." cols="30" rows="6" @error('meta_description')is-invalid @enderror>{{ $course->meta_description }}</textarea>
</div>
<div class="error"></div>
