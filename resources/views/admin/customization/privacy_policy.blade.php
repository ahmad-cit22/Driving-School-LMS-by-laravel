@extends('layouts.admin')
@section('content')
    <div class="row">
        {{-- Branches part --}}
        <div class="row">
            <div class="col-12 mt-3 mb-3">

                <div class="card p-3">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <form class="mb-5" action="{{ route('admin.customize.privacy_policy.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <h3 class="form-label mb-3">Update Privacy Policy</h3>
                                    <textarea name="privacy_policy" id="privacy_policy" cols="30" rows="15" @error('privacy_policy')is-invalid @enderror>{{ $privacy_policy->privacy_policy }}</textarea>

                                    @error('privacy_policy')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button class="btn btn-primary btn-sm mt-2 fs-6">Update Now</button>
                            </form>
                        </div>
                    </div>
                </div>
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
        $(document).ready(function() {
            $('#privacy_policy').summernote();
        });
    </script>

       @if (session('updateSuccess'))
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: '{{ session('updateSuccess') }}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
@endsection
