@csrf
<input type="hidden" name="id" value="{{ $doc->id }}">

<div class="form-group mt-3">
    <label class="form-label">Select Course</label>
    <select name="course_id" class="form-select select2 @error('course_id')is-invalid @enderror">
        <option value="0">-- Choose an Option --</option>
        @foreach ($courses as $key => $course)
            <option value="{{ $course->id }}" {{ $course->id == $doc->course_id ? 'selected' : '' }}>{{ $course->rel_to_course_cat->category_name }} - {{ $course->rel_to_course_type->type_name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group mt-3">
    <label class="form-label">Update File</label>
    <input type="file" name="file" class="form-control" accept=".jpg,.jpeg,.bmp,.gif,.doc,.docx,.csv,.rtf,.ppt,.xlsx,.xls,.txt,.pdf,.zip">
</div>
<div class="form-group mt-3">
    <label class="form-label">Update Note (If Needed)</label>
    <textarea class="form-control @error('note')is-invalid @enderror" name="note" placeholder="Enter the note here." cols="30" rows="6">{{ $doc->note }}</textarea>
</div>
<div class="error"></div>
