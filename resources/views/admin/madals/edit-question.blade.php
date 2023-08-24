@csrf
<input type="hidden" name="id" value="{{ $question->id }}">
<div class="mb-2">
    <label class="form-label">Question</label>
    <input type="text" class="form-control @error('question')is-invalid @enderror" name="question"
        value="{{ $question->question }}" placeholder="Enter Question" required>
    @error('question')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-2">
    <label class="form-label">Question Type</label>
    <select class="form-control cursor-pointer" name="question_type" id="question_type" required>
        <option value=""> -- Set Question Type -- </option>
        <option value="0" {{ $question->question_type == 0 ? 'selected' : '' }}>MCQ</option>
        <option value="1" {{ $question->question_type == 1 ? 'selected' : '' }}>True/False</option>
        <option value="2" {{ $question->question_type == 2 ? 'selected' : '' }}>Descriptive</option>
    </select>
    @error('question_type')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
{{-- add choices --}}
<label class="form-label">Add Choices for the Question</label>
@foreach ($choices as $choice)
    <div class="mb-2">
        <input type="text" class="form-control @error('choice')is-invalid @enderror" name="choice[]"
            value="{{ $choice->choice }}" placeholder="Enter a Choice" required>
    </div>
@endforeach

@error('choice[]')
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>
<label class="form-label">Right Answer</label>
<div class="mb-2">
    <select class="form-control cursor-pointer" name="right_answer" id="right_answer" required>
        <option value=""> -- Set Right Answer -- </option>
        <option value="1" {{ $question->right_answer == 1 ? 'selected' : '' }}>1</option>
        <option value="2" {{ $question->right_answer == 2 ? 'selected' : '' }}>2</option>
        <option value="3" {{ $question->right_answer == 3 ? 'selected' : '' }}>3</option>
        <option value="4" {{ $question->right_answer == 4 ? 'selected' : '' }}>4</option>
    </select>
    @error('right_answer')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<label class="form-label">Marks</label>
<div class="mb-2">
    <select class="form-control cursor-pointer" name="marks" id="marks" required>
        <option value=""> -- Set the Marks for the Question -- </option>
        <option value="1" {{ $question->marks == 1 ? 'selected' : '' }}>1</option>
        <option value="2" {{ $question->marks == 2 ? 'selected' : '' }}>2</option>
        <option value="3" {{ $question->marks == 3 ? 'selected' : '' }}>3</option>
        <option value="4" {{ $question->marks == 4 ? 'selected' : '' }}>4</option>
        <option value="5" {{ $question->marks == 5 ? 'selected' : '' }}>5</option>
        <option value="6" {{ $question->marks == 6 ? 'selected' : '' }}>6</option>
        <option value="7" {{ $question->marks == 7 ? 'selected' : '' }}>7</option>
        <option value="8" {{ $question->marks == 8 ? 'selected' : '' }}>8</option>
        <option value="9" {{ $question->marks == 9 ? 'selected' : '' }}>9</option>
        <option value="10" {{ $question->marks == 10 ? 'selected' : '' }}>10</option>
    </select>
    @error('marks')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
