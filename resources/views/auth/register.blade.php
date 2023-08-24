<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Loding font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,700" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous" />

    <!-- font awesome  -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />

    <!-- Custom Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/login_styles.css') }}">

    <title>Register</title>
</head>

<body>

    <!-- Backgrounds -->

    <div id="login-bg" class="container-fluid">

        <div class="bg-img"></div>
        {{-- <div class="bg-color"></div> --}}
    </div>

    <!-- End Backgrounds -->

    <div class="container" id="register">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="login register">
                    <div class="logo">
                        <a href="{{ url('/') }}"><img src="{{ asset('uploads/logos/' . $settings->logo_dark) }}" alt="logo"></a>
                    </div>
                    <h1>Register</h1>

                    <!-- Register form -->
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Enter Your Name" required autofocus>

                            @error('name')
                                <span class="invalid-feedback errMsg" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter Email Address" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback errMsg" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="mobile" type="tel" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" placeholder="Enter Mobile Number" required autocomplete="mobile" autofocus>

                            @error('mobile')
                                <span class="invalid-feedback errMsg" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="nid" type="number" class="form-control @error('nid') is-invalid @enderror" name="nid" value="{{ old('nid') }}" placeholder="Enter NID No." required autocomplete="nid" autofocus>

                            @error('nid')
                                <span class="invalid-feedback errMsg" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group" id="password-box">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter Password" required>
                            <span id="password_eye" onclick="password_show_hide();">
                                <i class="fas fa-eye" id="show-eye"></i>
                                <i class="fas fa-eye-slash d-none" id="hide-eye"></i>
                            </span>

                            @error('password')
                                <span class="invalid-feedback errMsg" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group" id="password-box2">
                            <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="Confirm your password" required>
                            <span id="password_eye2" onclick="password_show_hide2();">
                                <i class="fas fa-eye" id="show-eye2"></i>
                                <i class="fas fa-eye-slash d-none" id="hide-eye2"></i>
                            </span>

                            @error('password_confirmation')
                                <span class="invalid-feedback errMsg" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <br>
                        <button type="submit" class="btn btn-lg btn-block btn-success">Register Now</button>
                    </form>
                    <!-- End Register form -->
                    <div class="footer-text mb-2">
                        <label class="fw-bold reg-btn" style="font-weight: bold;">Already have an account? <a class="ml-2 site-text-primary" href="{{ route('login') }}">Login Now<a></label>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function password_show_hide() {
            let x = document.getElementById("password");
            let password_eye = document.getElementById("password_eye");
            let show_eye = document.getElementById("show-eye");
            let hide_eye = document.getElementById("hide-eye");
            password_eye.style.marginTop = ".25vw";
            if (screen.width <= 600) {
                password_eye.style.marginTop = ".9vw";
            }

            hide_eye.classList.remove("d-none");
            if (x.type === "password") {
                x.type = "text";
                show_eye.style.display = "none";
                hide_eye.style.display = "block";
            } else {
                x.type = "password";
                show_eye.style.display = "block";
                hide_eye.style.display = "none";
            }
        }

        function password_show_hide2() {
            let x = document.getElementById("password_confirmation");
            let password_eye = document.getElementById("password_eye2");
            let show_eye = document.getElementById("show-eye2");
            let hide_eye = document.getElementById("hide-eye2");
            password_eye.style.marginTop = ".25vw";
            if (screen.width <= 600) {
                password_eye.style.marginTop = ".9vw";
            }

            hide_eye.classList.remove("d-none");
            if (x.type === "password") {
                x.type = "text";
                show_eye.style.display = "none";
                hide_eye.style.display = "block";
            } else {
                x.type = "password";
                show_eye.style.display = "block";
                hide_eye.style.display = "none";
            }
        }
    </script>
</body>

</html>
