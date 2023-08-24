@extends('layouts.admin')
@if (auth()->user()->hasRole([1, 2]))
    @section('top-btn')
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUser">
            <i class="fa-solid fa-user-plus"></i>
            @if (auth()->user()->hasRole(1))
                Add User
            @else
                Add Instructor
            @endif
        </button>
    @endsection
@endif

@section('content')
    @if (auth()->user()->hasRole(1))
        <!-- Admin List -->
        <div class="card">
            <div class="card-header">
                <h3 class="fs-5 m-0 py-2">Admin Users</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="datatable table-striped table-bordered table text-center align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile No</th>
                                <th>Role</th>
                                @if (auth()->user()->hasRole(1))
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($admin_users as $user)
                                <tr>
                                    <td>
                                        <div class="user-active">
                                            <img src="{{ $user->image ? asset('uploads/users/' . $user->image) : Avatar::create($user->name)->toBase64() }}" class="user-profile" alt="{{ $user->name }}">
                                        </div>
                                    </td>
                                    <td>{{ $user->name }} @if ($user->id == auth()->user()->id)
                                            <span class="badge rounded-pill bg-secondary fw-light">You</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->mobile }}</td>
                                    <td>
                                        <span class="permission-list">{{ $user->roles->first()->name }}</span>
                                    </td>
                                    @if (auth()->user()->hasRole(1))
                                        <td>
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View"><i class="fa-solid fa-eye"></i></a>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">No Users Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Branch Manager List -->
        <div class="card">
            <div class="card-header">
                <h3 class="fs-5 m-0 py-2">Branch Manager Users</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="datatable table-striped table-bordered table text-center align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile No</th>
                                <th>Role</th>
                                <th>Branch</th>
                                @if (auth()->user()->hasRole(1))
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($branch_manager_users as $user)
                                <tr>
                                    <td>
                                        <div class="user-active">
                                            <img src="{{ $user->image ? asset('uploads/users/' . $user->image) : Avatar::create($user->name)->toBase64() }}" class="user-profile" alt="{{ $user->name }}">
                                        </div>
                                    </td>
                                    <td>{{ $user->name }} @if ($user->id == auth()->user()->id)
                                            <span class="badge rounded-pill bg-secondary fw-light">You</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->mobile }}</td>
                                    <td>
                                        @if (auth()->user()->hasRole(1))
                                            <select class="form-select role select2" data-user-id="{{ $user->id }}">
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}" {{ $user->roles->first()->id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <span class="permission-list">{{ $user->roles->first()->name }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->branch)
                                            {{ $user->branch->branch_name }}
                                        @else
                                            @if (auth()->user()->hasRole(1))
                                                <button type="button" class="btn btn-primary assign-branch" data-user_id="{{ $user->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Assign Branch"><i class="far fa-plus"></i></button>
                                            @else
                                                -
                                            @endif
                                        @endif
                                    </td>
                                    @if (auth()->user()->hasRole(1))
                                        <td>
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View"><i class="fa-solid fa-eye"></i></a>
                                            <button class="btn btn-danger btn-sm delete" data-id="{{ $user->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">No Users Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- Instructor List -->
    <div class="card">
        <div class="card-header">
            <h3 class="fs-5 m-0 py-2">Instructor Users</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="datatable table-striped table-bordered table text-center align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile No</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($instructor_users as $user)
                            <tr>
                                <td>
                                    <div class="user-active">
                                        <img src="{{ $user->image ? asset('uploads/users/' . $user->image) : Avatar::create($user->name)->toBase64() }}" class="user-profile" alt="{{ $user->name }}">
                                    </div>
                                </td>
                                <td>{{ $user->name }} @if ($user->id == auth()->user()->id)
                                        <span class="badge rounded-pill bg-secondary fw-light">You</span>
                                    @endif
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->mobile }}</td>
                                <td>
                                    @if (auth()->user()->hasRole(1))
                                        <select class="form-select role select2" data-user-id="{{ $user->id }}">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}" {{ $user->roles->first()->id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <span class="permission-list">{{ $user->roles->first()->name }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View"><i class="fa-solid fa-eye"></i></a>
                                    @if (auth()->user()->hasRole(1))
                                        <button class="btn btn-danger btn-sm delete" data-id="{{ $user->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fa-solid fa-trash"></i></button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No Users Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if (auth()->user()->hasRole([1, 2]))
        <!-- Add User Modal -->
        @include('admin.madals.add-user')
    @endif
    <!-- Assign Branch Modal -->
    <div class="modal fade" id="assignBranch" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="assign-branch-form">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Asign Branch</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h3>...</h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Assign</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('.role').change(function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, do it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let role_id = $(this).children("option:selected").val();
                    let user_id = $(this).data("user-id");
                    $.ajax({
                        method: 'POST',
                        url: "{{ route('admin.role.assign') }}",
                        data: {
                            role_id: role_id,
                            user_id: user_id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            window.location.reload();
                        }
                    });
                } else if (result.isDismissed) {
                    window.location.reload();
                }
            });

        });


        @if (auth()->user()->hasRole([1, 2]))
            $('#add-user').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    method: 'POST',
                    url: "{{ route('admin.users.add') }}",
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            $('#addUser').modal('hide');
                            location.reload();
                        } else {
                            let errors = response.errors;
                            let errorsHtml = '<div class="alert alert-danger alert-dismissible fade show"><ul class="m-0">';

                            $.each(errors, function(key, value) {
                                errorsHtml += '<li>' + value + '</li>';
                            });
                            errorsHtml += '</ul><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';

                            $('#form-errors').html(errorsHtml);
                        }
                    }
                });
            });

            $('#password-show').click(function() {
                if ($('#password').attr('type') == 'password') {
                    $('#password').attr('type', 'text');
                    $('#password-show i').removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    $('#password').attr('type', 'password');
                    $('#password-show i').removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        @endif

        @if (auth()->user()->hasRole(1))
            $('.assign-branch').click(function() {
                let user_id = $(this).data('user_id');
                let url = "{{ route('admin.branches.assign.modal', ':id') }}";
                url = url.replace(':id', user_id);
                $.ajax({
                    method: 'get',
                    url: url,
                    success: function(response) {
                        $('#assignBranch').modal('show');
                        $('#assignBranch .modal-body').html(response);
                    }
                })
            });

            $('#assign-branch-form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    method: 'POST',
                    url: "{{ route('admin.branches.assign') }}",
                    data: $(this).serialize(),
                    success: function(response) {
                        window.location.reload();
                    }
                });
            });

            $('.delete').click(function() {
                let id = $(this).data('id');
                let url = "{{ route('admin.users.delete', ':id') }}";
                url = url.replace(':id', id);
                delete_warning(url);
            });
        @endif
    </script>
@endsection
