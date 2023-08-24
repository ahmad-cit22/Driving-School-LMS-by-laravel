@csrf
<input type="hidden" name="id" value="{{ $blog->id }}">

<div class="mb-3">
    <label class="form-label">Update Category</label>
    <input type="text" class="form-control @error('blog_category')is-invalid @enderror" name="blog_category" placeholder="Enter The Blog Category" value="{{ $blog->blog_category }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Update Blog Title</label>
    <input type="text" class="form-control @error('blog_title')is-invalid @enderror" name="blog_title" placeholder="Enter The Blog Title" value="{{ $blog->blog_title }}" required>
</div>
@php
    if ($blog->blog_banner_image != null) {
        $blog_img = $blog->blog_banner_image;
    } else {
        $blog_img = 'def-image.jpg';
    }
    
@endphp
<div class="mb-3">
    <label class="form-label">Update Blog Banner Image</label>
    <div class="img my-2">
        <img id="blog_image_preview" src="{{ asset('assets/frontend/img/blog/' . $blog_img) }}" alt="{{ $blog_img }}" width="150">
    </div>
    <input type="file" class="form-control" id="blog_banner_image" name="blog_banner_image" onchange="document.getElementById('blog_image_preview').src = window.URL.createObjectURL(this.files[0])">
</div>
<div class="mb-3">
    <label class="form-label">Update Blog Post</label>
    <textarea name="blog_post" id="edit_blog_post" cols="30" rows="25" @error('blog_post')is-invalid @enderror required>{!! $blog->blog_post !!}</textarea>
</div>
<div class="mb-3">
    <label class="form-label">Meta Description</label>
    <textarea class="form-control" name="meta_description" id="meta_description" placeholder="Enter the meta description that will be placed inside the head tag." cols="30" rows="6" @error('meta_description')is-invalid @enderror>{{ $blog->meta_description }}</textarea>
</div>
<div class="mb-3">
    <label class="form-label">Update Tags</label>
    <select class="form-select select2" id="multiple-select-field2" data-placeholder="Choose Tags For Blog" multiple name="blog_tags[]">
        <option value="0"></option>
        @foreach ($tags as $tag)
            <option value="{{ $tag->id }}" {{ in_array($tag->id, $tagIds) ? 'selected' : '' }}>{{ $tag->tag_name }}</option>
        @endforeach
    </select>
</div>
<div class="error mb-3"></div>

@section('script')
@endsection
