@csrf
<input type="hidden" name="id" value="{{ $course_type->id }}">
<div class="mb-3">
    <label class="form-label">Course Type</label>
    <input class="form-control" type="text" name="type_name" value="{{ $course_type->type_name }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Duration</label>
    <div class="input-group">
        <input class="form-control" type="number" name="duration" value="{{ $course_type->duration }}" required>
        <span class="input-group-text">Days</span>
        @error('duration')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="mb-3">
    <label class="form-label">Max Duration</label>
    <div class="input-group">
        <input class="form-control" type="number" name="max_duration" value="{{ $course_type->max_duration }}" required>
        <span class="input-group-text">Days</span>
        @error('max_duration')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
