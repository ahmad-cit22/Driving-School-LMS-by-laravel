@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="card shadow-none border">
                        <div class="card-header">
                            <h6 class="mb-0">USER INFORMATION</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.user.update.info') }}" method="POST" class="row g-3">
                                @csrf
                                <input type="hidden" name="id" value="{{ $user->id }}">
                                <div class="col-md-6">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name') ?? $user->name }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="text" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" value="{{ old('email') ?? $user->email }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Mobile</label>
                                    <input type="tel" name="mobile" class="form-control  {{ $errors->has('mobile') ? 'is-invalid' : '' }}" value="{{ old('mobile') ?? $user->mobile }}">
                                    @error('mobile')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="address">Present Address</label>
                                    <input type="text" name="address" id="address" class="form-control" placeholder="Enter Your Present Address" value="{{ old('address') ?? $user->address }}">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="b_date">Date of Birth</label>
                                    <input type="date" name="b_date" id="b_date" class="form-control" placeholder="Enter Your Date of Birth" value="{{ old('b_date') ?? $user->b_date }}">
                                    @error('b_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="nid">NID No.</label>
                                    <input type="number" name="nid" id="nid" class="form-control" placeholder="Enter Your NID Number" value="{{ old('nid') ?? $user->nid }}">
                                    @error('nid')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @hasrole(1)
                                    @if ($user->hasRole([1, 2, 3]))
                                        <div class="col-md-6">
                                            <label class="form-label">Role</label>
                                            @if ($user->hasRole(1))
                                                <input type="hidden" name="role_id" value="{{ $user->roles->first()->id }}">
                                                <select class="form-select" disabled>
                                                    <option>{{ $user->roles->first()->name }}</option>
                                                </select>
                                            @else
                                                <select class="form-select" name="role_id">
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id || $user->hasRole($role->id) ? 'selected' : '' }}>{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>
                                    @endif
                                    @if ($user->hasRole(2))
                                        <div class="col-md-6">
                                            <label class="form-label">Branch</label>
                                            <select class="form-select" name="branch_id">
                                                @foreach ($branches as $branch)
                                                    <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id || $branch->id == $user->branch_id ? 'selected' : '' }}>{{ $branch->branch_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                @endhasrole
                                <div class="text-start">
                                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!--change password-->
            <div class="card shadow-none border">
                <div class="card-header">
                    <h6 class="mb-0">Change Password</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.user.update.password') }}" method="POST" class="row g-3">
                        @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <div class="col-md-6">
                            <label class="form-label">New Password</label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control  @error('password') is-invalid @enderror" id="password" placeholder="Enter new password" value="{{ old('password') }}" required>
                                <span class="input-group-text" id="password-show"><i class="fa-solid fa-eye"></i></span>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" name="confirm_password" class="form-control  @error('confirm_password') is-invalid @enderror" id="confirm_password" placeholder="Enter confirm password" value="{{ old('confirm_password') }}" required>
                                <span class="input-group-text" id="confirm_password-show"><i class="fa-solid fa-eye"></i></span>
                                @error('confirm_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="text-start">
                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card shadow-sm border-0 overflow-hidden">
                <div class="card-body">
                    <div class="text-center">
                        <img id="profile-pic" src="{{ $user->image ? asset('uploads/users/' . $user->image) : Avatar::create($user->name)->toBase64() }}" class="profile-avatar shadow" width="120" height="120" alt="{{ $user->name }}">
                        <span class="activity profile {{ Cache::has('user-is-online-' . $user->id) ? 'bg-success' : 'bg-offline' }}"><span class="visually-hidden">.</span></span>
                    </div>
                    <div class="text-center mt-4">
                        <h4 class="mb-1">{{ $user->name }}</h4>
                        <p class="mb-0 text-secondary">{{ $user->getRoleNames()->first() }}</p>
                        <p class="mb-0 text-secondary">Mobile No: {{ $user->mobile }}</p>
                        <p class="mb-0 text-secondary">Email: {{ $user->email }}</p>
                        <div class="mt-4"></div>
                    </div>
                    <div class="mt-5">
                        <form action="{{ route('admin.user.update.pro.pic') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <div class="mb-3">
                                <label for="image" class="form-label">Profile Picture <small>(Supported JPG & PNG)</small></label>
                                <input type="file" name="image" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" onchange="document.getElementById('profile-pic').src = window.URL.createObjectURL(this.files[0])" accept="image/jpeg, image/png">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#password-show').click(function() {
                if ($('#password').attr('type') == 'password') {
                    $('#password').attr('type', 'text');
                    $('#password-show i').removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    $('#password').attr('type', 'password');
                    $('#password-show i').removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
            $('#confirm_password-show').click(function() {
                if ($('#confirm_password').attr('type') == 'password') {
                    $('#confirm_password').attr('type', 'text');
                    $('#confirm_password-show i').removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    $('#confirm_password').attr('type', 'password');
                    $('#confirm_password-show i').removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        });
    </script>
@endsection
