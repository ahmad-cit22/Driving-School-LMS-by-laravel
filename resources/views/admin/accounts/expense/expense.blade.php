@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12">

            <div class="row">
                <div class="col-6 col-lg-2 bg-light-success round-xl">
                    <div class="p-3">
                        <h6>Total Expense</h6>
                        <h5 class="pt-2 site-text-primary">&#2547; {{ $expenses->sum('amount') }}</h5>
                    </div>
                </div>
                @foreach ($branches as $branch)
                    <div class="col-6 col-lg-2 round-xl">
                        <div class="p-3">
                            <h6>{{ $branch->branch_name }} Branch</h6>
                            <h5 class="pt-2 site-text-primary">&#2547; {{ $branch->expenses->sum('amount') }}</h5>
                        </div>
                    </div>
                @endforeach


            </div>

            <!-- Expenses -->
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="m-0 fs-5">Expenses</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped datatable table-bordered text-center align-middle">
                            <thead>
                                <tr>
                                    <th width="">SL</th>
                                    <th width="">Amount</th>
                                    <th width="">Branch</th>
                                    <th width="">Note</th>
                                    @hasrole(1)
                                        <th width=''>Action</th>
                                    @endhasrole
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($expenses as $key => $expense)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>BDT {{ number_format($expense->amount) }}</td>
                                        <td>{{ $expense->rel_to_branch->branch_name }}</td>
                                        <td>{{ $expense->note ? $expense->note : '--' }}</td>
                                        @hasrole(1)
                                            <td>
                                                <button class="btn btn-primary btn-sm edit-expense" data-id="{{ $expense->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="fa-solid fa-pencil"></i></button>
                                                <button class="btn btn-danger btn-sm delete-expense" data-id="{{ $expense->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fa-solid fa-trash"></i></button>
                                            </td>
                                        @endhasrole
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">No Entry Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="row">
        <div class="col-12 col-lg-5 mx-auto">
            <div class="card p-3">
                <div class="card-header">
                    <h3 class="m-0 fs-5">Add New Entry</h3>
                </div>
                <div class="card-body">
                    <form id="add-expense-form">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Amount</label>
                            <input type="number" class="form-control @error('amount')is-invalid @enderror" name="amount" placeholder="Enter The Amount" value="{{ old('amount') }}">
                            {{-- @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror --}}
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Branch</label>
                            <select name="branch" class="form-select select2 @error('branch')is-invalid @enderror">
                                <option value="0">-- Select A Branch --</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ $branch->id == old('branch') ? 'selected' : '' }}>{{ $branch->branch_name }}</option>
                                @endforeach
                            </select>
                            {{-- @error('branch_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror --}}
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Note</label>
                            <textarea class="form-control" name="note" id="" cols="30" rows="6" placeholder="Add note about the income"></textarea>
                            {{-- @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror --}}
                        </div>
                        <div class="error mb-3"></div>
                        <button class="mt-2 btn btn-primary btn-sm">Add Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- expense Edit Model -->
    <div class="modal fade" id="editExpense" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="edit-expense-form">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Edit Expense Entry</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h3>...</h3>
                        <div class="error"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        .slot-day {
            display: none;
        }

        form .error {
            font-size: .9em;
            color: #dc3545;
            display: none;
        }
    </style>
@endsection

@section('script')
    <script>
        $('#add-expense-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: "{{ route('admin.expense.add') }}",
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        let errors = response.errors;
                        let errorsHtml = '<ul class="m-0 mt-2 fw-light">';
                        $.each(errors, function(key, value) {
                            errorsHtml += '<li class= "fw-bold">' + value + '</li>';
                        });
                        errorsHtml += '</ul>';
                        $('#add-expense-form .error').html(errorsHtml);
                        $('#add-expense-form .error').show();

                    }
                }
            });
        });

        // edit course
        $('.edit-expense').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.expense.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                method: 'get',
                url: url,
                success: function(response) {
                    if (!response.error) {
                        $('#editExpense').modal('show');
                        $('#editExpense .modal-body').html(response);
                    } else {
                        Swal.fire(
                            'Sorry',
                            "Unauthorized access!",
                            'error',
                        )
                    }
                }
            })
        });

        $('#edit-expense-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: "{{ route('admin.expense.update') }}",
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else if (response.error) {
                        Swal.fire(
                            'Sorry',
                            "Unauthorized access!",
                            'error',
                        )
                    } else {
                        let errors = response.errors;
                        let errorsHtml = '<ul class="m-0 mt-2 fw-light">';
                        $.each(errors, function(key, value) {
                            errorsHtml += '<li class= "fw-bold">' + value + '</li>';
                        });
                        errorsHtml += '</ul>';
                        $('#edit-expense-form .error').html(errorsHtml);
                        $('#edit-expense-form .error').show();

                    }
                }
            });
        });


        $('.delete-expense').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('admin.expense.delete', ':id') }}";
            url = url.replace(':id', id);
            delete_warning(url);
        });
    </script>
@endsection
