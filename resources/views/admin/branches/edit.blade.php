@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="card shadow-none border">
                        <div class="card-header">
                            <h6 class="mb-0">Edit Branch</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.branches.update') }}" method="POST" class="row g-3">
                                @csrf
                                <input type="hidden" name="branch_id" value="{{ $branch->id }}">
                                <div class="col-md-12">
                                    <label class="form-label">Branch Name</label>
                                    <input type="text" name="branch_name" class="form-control {{ $errors->has('branch_name') ? 'is-invalid' : '' }}" value="{{ old('branch_name') ?? $branch->branch_name }}">
                                    @error('branch_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Branch Address</label>
                                    <textarea name="branch_address" class="form-control {{ $errors->has('branch_address') ? 'is-invalid' : '' }}">{{ old('branch_address') ?? $branch->branch_address }}</textarea>
                                    @error('branch_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Branch Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $branch->email }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Branch Phone No.</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" value="{{ $branch->phone }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Theory Class (Day)</label>
                                    <select name="theory_classes[]" id="theory_class" class="form-select select2 {{ $errors->has('theory_classes') ? 'is-invalid' : '' }}" multiple>
                                        <option></option>
                                        @foreach ($days as $day)
                                            <option value="{{ $day->id }}">{{ $day->day }}</option>
                                        @endforeach
                                    </select>
                                    @error('theory_classes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="text-start">
                                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    @php
        $id = '';
        foreach ($branch->theory_class as $value) {
            $id .= $value->days->id . ', ';
        }
    @endphp
    <script>
        $('#theory_class').select2().val([{{ $id }}]).trigger('change');
    </script>
@endsection
