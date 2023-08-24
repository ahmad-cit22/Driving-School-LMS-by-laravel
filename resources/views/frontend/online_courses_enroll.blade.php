@extends('layouts.frontend')
@section('content')
    <div class="container py-5">
        <div class="card border-0">
            <div class="card-body">
                <form id="online-course-enroll">
                    @csrf
                    <div class="row">
                        @guest
                            <div class="form-group col-md-6">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Please enter your full name">
                                <div class="error"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="mobile">Mobile Number</label>
                                <input type="phone" name="mobile" id="mobile" class="form-control" placeholder="Please Enter a valid mobile number">
                                <div class="error"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="(Optional)">
                                <div class="error"></div>
                            </div>
                        @endguest
                        <div class="form-group col-md-6">
                            <label for="course_id">Which Course You Want to Get?</label>
                            <select name="course_id" id="course_id" class="form-control select2" required>
                                <option value="0"> -- Choose A Course -- </option>
                                @foreach ($online_courses as $online_course)
                                    <option value="{{ $online_course->id }}">{{ $online_course->course_title }} ({{ $online_course->rel_to_course_cat->category_name }})</option>
                                @endforeach
                            </select>
                            <div class="error"></div>
                        </div>
                        @guest
                            <div class="form-group col-md-6">
                                <label for="password">Password</label>
                                <span id="show-password"><i class="fa-solid fa-eye"></i></span>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" autocomplete="off">
                                <div class="error"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password" autocomplete="off">
                                <div class="error"></div>
                            </div>
                        @endguest
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn primary" id="submit">Enroll Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="login-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        form .error {
            font-size: .9em;
            color: #dc3545;
            display: none;
        }

        form .form-control.is-invalid {
            background-image: unset;
        }

        form #show-password {
            position: absolute;
            right: 30px;
            top: 40px;
        }
    </style>
@endsection

@section('script')
    <script>
        let vidCourseFormData = JSON.parse(localStorage.getItem("vidCourseFormData"));
        if (!vidCourseFormData) {
            vidCourseFormData = {};
        }

        $("#online-course-enroll").submit(function(e) {
            e.preventDefault();
            let data = {};
            localStorage.setItem('vidCourseFormData', JSON.stringify(data));

            $.ajax({
                method: 'POST',
                url: "{{ route('enroll.vid_course.store') }}",
                data: $(this).serialize(),
                success: function(response) {
                    // alert();
                    // alert(response);
                    $('.error').html('');
                    $('input').removeClass('is-invalid');
                    $('select').removeClass('is-invalid');
                    if (response.success) {
                        localStorage.removeItem("vidCourseFormData");
                        window.location.href = '{{ route('otp') }}';
                    } else if (response.errors) {
                        let errors = response.errors;
                        $.each(errors, function(key, value) {
                            let field = '#' + key;
                            $(field).addClass('is-invalid');
                            $(field).siblings('.error').html(value);
                            $(field).siblings('.error').css('display', 'block');
                        });
                    } else {
                        $('#login-modal').modal('show');
                        $('#login-modal .modal-content').html(response);
                    }
                }
            });
        });

        $('#show-password').click(function() {
            if ($('#password').attr('type') == 'password') {
                $('#password').attr('type', 'text');
                $('#confirm_password').attr('type', 'text');
                $('#show-password i').removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                $('#password').attr('type', 'password');
                $('#confirm_password').attr('type', 'password');
                $('#show-password i').removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    </script>
@endsection
