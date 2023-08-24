@csrf
<input type="hidden" name="id" value="{{ $feature->id }}">
<div class="mb-2">
    <label class="form-label">Title</label>
    <input type="text" class="form-control @error('title')is-invalid @enderror" name="title" value="{{ $feature->title }}" placeholder="Enter Title" required>
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-2">
    <label class="form-label">Fetaure Text</label>
    <input type="text" class="form-control @error('text')is-invalid @enderror" name="text" value="{{ $feature->text }}" placeholder="Enter Fetaure Text" required>
    @error('text')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-2">
    <label class="form-label">Icon</label>
    <input type="text" class="form-control @error('icon')is-invalid @enderror" name="icon" value="{{ $feature->icon }}" placeholder="Enter Icon" required>
    @error('icon')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-2">
    <label class="form-label">Priority</label>
    <input type="number" class="form-control @error('priority')is-invalid @enderror" name="priority" value="{{ $feature->priority }}" placeholder="Enter Priority Number" required>
    @error('priority')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
