@csrf
<input type="hidden" name="id" value="{{ $certified_by_part->id }}">
<div class="mb-2">
    <label class="form-label">Certified By</label>
    <input type="text" class="form-control @error('certified_by')is-invalid @enderror" name="certified_by" value="{{ $certified_by_part->certified_by }}" placeholder="Enter the certifier institution name." required>
    @error('certified_by')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-2">
    <div class="my-2">
        <img id="certificate_image_preview" src="{{ asset('assets/frontend/img/footer/' . $certified_by_part->certificate_image) }}" alt="{{ $certified_by_part->certificate_image }}" width="100">
    </div>
    <label class="form-label">Certificate Image</label>
    <input type="file" class="form-control @error('certificate_image')is-invalid @enderror" name="certificate_image" onchange="document.getElementById('certificate_image_preview').src = window.URL.createObjectURL(this.files[0])">
    @error('certificate_image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="error"></div>
