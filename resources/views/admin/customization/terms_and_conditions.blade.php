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
                            <form class="mb-5" action="{{ route('admin.customize.terms_and_conditions.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <h3 class="form-label mb-3">Update Terms & Conditions</h3>
                                    <textarea name="terms_and_conditions" id="terms_and_conditions" cols="30" rows="15" @error('terms_and_conditions')is-invalid @enderror>{{ $terms_and_conditions->terms_and_conditions }}</textarea>

                                    @error('terms_and_conditions')
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
            $('#terms_and_conditions').summernote();
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
