@csrf
<input type="hidden" name="id" value="{{ $gallery_image->id }}">
<div class="mb-3">
    <label class="form-label">Image Class</label>
    <select name="image_class" class="form-select select2 @error('image_class')is-invalid @enderror" required>
        <option value=""> -- Select a class -- </option>
        <option value="vehicles" {{ $gallery_image->image_class == 'vehicles' ? 'selected' : '' }}>vehicles</option>
        <option value="classrooms" {{ $gallery_image->image_class == 'classrooms' ? 'selected' : '' }}>classrooms</option>
        <option value="students" {{ $gallery_image->image_class == 'students' ? 'selected' : '' }}>students</option>
        <option value="exams" {{ $gallery_image->image_class == 'exams' ? 'selected' : '' }}>exams</option>
    </select>
    @error('image_class')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label class="form-label">Update Image</label>
    <div class="img my-2">
        <img id="gallery_image_preview" src="{{ asset('assets/frontend/img/gallery/' . $gallery_image->image) }}" alt="{{ $gallery_image->image }}" width="150">
    </div>
    <input type="file" class="form-control" id="gallery_image" name="gallery_image" onchange="document.getElementById('gallery_image_preview').src = window.URL.createObjectURL(this.files[0])">
    @error('gallery_image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="error"></div>
