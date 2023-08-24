@csrf
<input type="hidden" name="id" value="{{ $counter->id }}">
<div class="mb-2">
    <label class="form-label">Amount</label>
    <input type="text" class="form-control @error('amount')is-invalid @enderror" name="amount" value="{{ $counter->amount }}" placeholder="Enter amount" required>
    @error('amount')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-2">
    <label class="form-label">Fetaure Text</label>
    <input type="text" class="form-control @error('text')is-invalid @enderror" name="text" value="{{ $counter->text }}" placeholder="Enter Fetaure Text" required>
    @error('text')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-2">
    <label class="form-label">Icon</label>
    <input type="text" class="form-control @error('icon')is-invalid @enderror" name="icon" value="{{ $counter->icon }}" placeholder="Enter Icon" required>
    @error('icon')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-2">
    <label class="form-label">Priority</label>
    <input type="number" class="form-control @error('priority')is-invalid @enderror" name="priority" value="{{ $counter->priority }}" placeholder="Enter Priority Number" required>
    @error('priority')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
