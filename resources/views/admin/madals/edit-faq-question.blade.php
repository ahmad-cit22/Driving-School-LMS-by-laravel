@csrf
<input type="hidden" name="id" value="{{ $question->id }}">
<div class="mb-3">
    <label class="form-label">Question</label>
    <input type="text" class="form-control @error('question')is-invalid @enderror" name="question" value="{{ $question->question }}" placeholder="Enter the FAQ Question.">
    @error('question')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label class="form-label">Answer</label>
    <textarea class="form-control @error('answer')is-invalid @enderror" name="answer" placeholder="Enter the answer." cols="30" rows="6">{{ $question->answer }}</textarea>
    @error('answer')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="error"></div>
