<form id="login-modal-form">@csrf
    <input type="hidden" name="mobile" value="{{ $mobile }}">
    <div class="modal-header">
        <h6 class="modal-title">User Login</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="alert alert-danger" role="alert">User already registered. Kindly enter the password to login.</div>
        <div class="form-group position-relative">
            <label for="login_password">Password</label>
            <span id="show-password-modal"><i class="fa-solid fa-eye"></i></span>
            <input type="password" name="login_password" id="login_password" class="form-control" placeholder="Please enter password">
            <div class="error"></div>
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <div><a href="{{ route('password.request') }}">Forget your password?</a></div>
        <button type="submit" class="btn primary">Login</button>
    </div>
</form>

<style>
    form #show-password-modal {
        position: absolute;
        right: 15px;
        top: 40px;
    }
</style>

<script>
    $('#show-password-modal').click(function() {
        if ($('#login_password').attr('type') == 'password') {
            $('#login_password').attr('type', 'text');
            $('#show-password-modal i').removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            $('#login_password').attr('type', 'password');
            $('#show-password-modal i').removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
    $('#login-modal-form').submit(function(e) {
        e.preventDefault();
        $.ajax({
            method: 'POST',
            url: "{{ route('enroll.login') }}",
            data: $(this).serialize(),
            success: function(response) {
                $('.error').html('');
                $('input').removeClass('is-invalid');
                $('select').removeClass('is-invalid');
                if (response.success) {
                    location.reload();
                } else if (response.errors) {
                    let errors = response.errors;
                    $.each(errors, function(key, value) {
                        let field = '#' + key;
                        $(field).addClass('is-invalid');
                        $(field).siblings('.error').html(value);
                        $(field).siblings('.error').css('display', 'block');
                    });
                }
            }
        });
    });
</script>
