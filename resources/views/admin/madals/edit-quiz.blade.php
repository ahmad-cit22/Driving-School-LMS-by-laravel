@csrf
<input type="hidden" name="id" value="{{ $quiz->id }}">
<div class="mb-2">
    <label class="form-label">Course Category</label>
    <select class="form-control cursor-pointer" name="course_category" id="course_category" required>
        <option value=""> -- Select Course Category -- </option>
        @foreach ($course_categories as $category)
            <option value="{{ $category->id }}" {{ $quiz->course_id == $category->id ? 'selected' : '' }}>
                {{ $category->category_name }}</option>
        @endforeach
    </select>
    @error('course_category')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-2">
    <label class="form-label">Course Type</label>
    <select class="form-control cursor-pointer" name="course_type" id="course_type" required>
        <option value=""> -- Select Course Type -- </option>
        @foreach ($course_types as $type)
            <option value="{{ $type->id }}" {{ $quiz->course_type == $type->id ? 'selected' : '' }}>
                {{ $type->type_name }}</option>
        @endforeach
    </select>
    @error('course_type')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-2">
    <label class="form-label">Quiz Name</label>
    <input type="text" class="form-control @error('quiz_name')is-invalid @enderror" name="quiz_name"
        placeholder="Enter Quiz Name" value="{{ $quiz->quiz_name }}" required>
    @error('quiz_name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-2">
    <label class="form-label">Quiz Time Limit (Minutes)</label>
    <input type="number" class="form-control @error('time_limit')is-invalid @enderror" name="time_limit"
        value="{{ $quiz->time_limit }}" placeholder="Enter Time Limit (Minutes)" required>
    @error('time_limit')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-2">
    <label class="form-label">Quiz Status</label>
    <select class="form-control cursor-pointer" name="quiz_status" id="quiz_status" required>
        <option value=""> -- Set Quiz Status -- </option>
        <option value="0" {{ $quiz->quiz_status == 0 ? 'selected' : '' }}>Upcoming</option>
        <option value="1" {{ $quiz->quiz_status == 1 ? 'selected' : '' }}>Ongoing</option>
        <option value="2" {{ $quiz->quiz_status == 2 ? 'selected' : '' }}>Closed</option>
    </select>
    @error('quiz_status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
