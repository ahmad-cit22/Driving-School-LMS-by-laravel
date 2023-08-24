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

    <!-- Custom Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/login_styles.css') }}">

    <title>Reset Password</title>
</head>

<body>

    <!-- Backgrounds -->

    <div id="login-bg" class="container-fluid">

        <div class="bg-img"></div>
        {{-- <div class="bg-color"></div> --}}
    </div>

    <!-- End Backgrounds -->

    <div class="container" id="login">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="login">
                    <div class="logo">
                        <img src="{{ asset('uploads/logos/logo-dark.png') }}" alt="logo">
                    </div>
                    <h1 class="reset_heading">Reset Password</h1>

                    @if (session('status'))
                        <div class="alert alert-success my-1 fw-bold" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Reset Password form -->
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-group">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter Email Address" autofocus>

                            @error('email')
                                <span class="invalid-feedback errMsg" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <br>
                        <button type="submit" class="btn btn-lg btn-block btn-success">Send Password Reset Link</button>
                    </form>
                    <!-- Reset Password form -->

                </div>
            </div>
        </div>
    </div>


</body>

</html>
