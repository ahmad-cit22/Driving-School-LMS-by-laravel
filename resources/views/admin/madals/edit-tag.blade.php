@csrf
<input type="hidden" name="id" value="{{ $tag->id }}">

<div class="mb-3">
    <label class="form-label">Tag Name</label>
    <input type="text" class="form-control @error('tag_name')is-invalid @enderror" name="tag_name" placeholder="Enter The Blog Category" value="{{ $tag->tag_name }}" required>
</div>
<div class="error mb-3"></div>
