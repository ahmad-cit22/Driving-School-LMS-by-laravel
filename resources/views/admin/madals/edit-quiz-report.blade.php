@csrf
<input type="hidden" name="id" value="{{ $report->id }}">

<div class="mb-2">
    <label class="form-label">Participant Name</label>
    <input type="text" readonly class="form-control @error('participant')is-invalid @enderror" name="participant" placeholder="" value="{{ $report->rel_to_enroll->user->name }}">
</div>

<div class="mb-2">
    <label class="form-label">Score</label>
    <input type="number" class="form-control @error('score')is-invalid @enderror" name="score" placeholder="Enter The Score (Out of {{$report->rel_to_quiz->total_marks}})" value="{{ $report->score_in_num }}" required>
</div>

<div class="error"></div>
