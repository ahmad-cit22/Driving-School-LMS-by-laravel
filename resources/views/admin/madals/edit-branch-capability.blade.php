@if (count($branch_capabilities->where('branch_id', $branch->id)) > 0)
    <div id="form-errors"></div>
    @csrf
    @foreach ($course_categories as $course_category)
        @if ($branch_capabilities->where('category_id', $course_category->id)->first())
            <div class="mb-3">
                <label class="form-label">{{ $course_category->category_name }}</label>
                @php
                    $data = $branch_capabilities->where('category_id', $course_category->id)->first();
                @endphp
                <input class="form-control" type="number" name="{{ $data->id }}" value="{{ $data->available_vehical }}" required>
            </div>
        @endif
    @endforeach
@else
    <p>No data for edit.</p>
@endif
