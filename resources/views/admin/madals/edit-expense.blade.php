@csrf
<input type="hidden" name="id" value="{{ $expense->id }}">

<div class="mb-2">
    <label class="form-label">Amount</label>
    <input type="number" class="form-control @error('amount')is-invalid @enderror" name="amount" placeholder="Enter The Amount" value="{{ $expense->amount }}" required>
</div>
<div class="mb-2">
    <label class="form-label">Branch</label>
    <select name="branch" class="form-select select2 @error('branch')is-invalid @enderror" required>
        <option value="0">-- Select A Branch --</option>
        @foreach ($branches as $branch)
            <option value="{{ $branch->id }}" {{ $branch->id == $expense->branch_id ? 'selected' : '' }}>{{ $branch->branch_name }}</option>
        @endforeach
    </select>
</div>
<div class="mb-2">
    <label class="form-label">Note</label>
    <textarea class="form-control" name="note" id="" cols="30" rows="6" placeholder="Add note about the income"  required>{{ $expense->note }}</textarea>
</div>
<div class="error mb-2"></div>
