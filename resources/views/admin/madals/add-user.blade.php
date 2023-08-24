<div class="modal fade" id="addUser" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="add-user">
            <div class="modal-content">
                <div class="modal-header">
                    @if (auth()->user()->hasRole(1))
                        <h5 class="modal-title">Add Admin</h5>
                    @else
                        <h5 class="modal-title">Add Instructor</h5>
                    @endif
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="form-errors"></div>
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile No</label>
                        <input type="tel" class="form-control" id="mobile" name="mobile" required>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select" id="role" name="role" required>
                                    {{-- @can('change_role') --}}
                                    @foreach ($roles as $role)
                                        @if (auth()->user()->roles->first()->id < $role->id && $role->id != 4)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endif
                                    @endforeach
                                    {{-- @else --}}
                                    {{-- <option value="4">{{ $roles->first()->name }}</option> --}}
                                    {{-- @endcan --}}
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group flex-nowrap">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <span class="input-group-text" id="password-show"><i class="fa-solid fa-eye"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Now</button>
                </div>
            </div>
        </form>
    </div>
</div>
