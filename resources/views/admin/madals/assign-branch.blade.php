<!-- Ajax Modal -->

@csrf
<input type="hidden" name="user_id" value="{{ $user->id }}">
<p>Manager Name: {{ $user->name }}</p>
<label class="form-label">Branch Name</label>
<select class="form-select branch" name="branch_id">
    <option></option>
    @foreach ($branches as $branch)
        <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
    @endforeach
</select>

<script>
    $('.branch').select2({
        theme: "bootstrap-5",
        placeholder: 'Select an Option',
        width: '100%'
    });
</script>
