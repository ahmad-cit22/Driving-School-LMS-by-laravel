@csrf
<input type="hidden" name="id" value="{{ $course_category->id }}">
<div class="mb-2">
    <label class="form-label">Category Name</label>
    <input type="text" class="form-control @error('category_name')is-invalid @enderror" name="category_name" value="{{ $course_category->category_name }}" placeholder="Enter Category Name" required>
    @error('category_name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-2">
    <div class="img">
        <img class="mt-1" id="thumb-preview" src="{{ asset('assets/frontend/images/category/' . $course_category->image) }}" alt="" width="100">
    </div>
    <label class="form-label">Category Image</label>
    <input type="file" class="form-control @error('image')is-invalid @enderror" name="image" onchange="document.getElementById('thumb-preview').src = window.URL.createObjectURL(this.files[0])" accept=".jpg, .png, jpeg, .gif, .webp">
    @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="error"></div>
