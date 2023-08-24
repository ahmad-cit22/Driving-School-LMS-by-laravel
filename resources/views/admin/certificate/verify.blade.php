  @extends('layouts.admin')
  @section('content')
      {{-- Verify form --}}
      <div class="col-md-7 mt-3 mb-5 mx-auto">
          <div class="card p-3">
              <div class="card-header">
                  <h3 class="m-0 fs-5">Verify A Certificate</h3>
              </div>
              <div class="card-body">
                  <form action="{{ route('certificate.verify') }}" method="POST">
                      @csrf
                      <div class="mb-2">
                          <label class="form-label">Certificate ID</label>
                          <input type="text" class="form-control @error('certificate_id')is-invalid @enderror" name="certificate_id" value="{{ old('certificate_id') }}" placeholder="Enter The Certificate ID" required>
                          @error('certificate_id')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>
                      <button class="btn btn-primary btn-sm mt-2 fs-6">Verify Now</button>
                  </form>
              </div>
          </div>
      </div>
  @endsection

  @section('script')
      @if (session('verifySuccess'))
          <script>
              Swal.fire({
                  title: "{{ session('verifySuccess') }}",
                  html: "<div class='info'> <p> <b>Certificate ID:</b> {{ session('c_id') }}</p> <p> <b>Student Name:</b> {{ session('student_name') }}</p> <p> <b>Course Category:</b> {{ session('course_category') }}</p> <p> <b>Course Type:</b> {{ session('course_type') }}</p> </div>"
              })
          </script>
      @endif

      @if (session('verifyFailed'))
          <script>
              Swal.fire(
                  'Sorry!',
                  "{{ session('verifyFailed') }}",
                  'error'
              )
          </script>
      @endif
  @endsection
