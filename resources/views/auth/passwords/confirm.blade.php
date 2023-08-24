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

    <title>Confirm Password</title>
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
                    <h1 class="reset_heading">Confirm Password</h1>
                    <p class="">Please confirm your password before continuing.</p>


                    <!-- Confirm Password form -->
                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf
                        <div class="form-group">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter Password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <br>
                        <button type="submit" class="btn btn-lg btn-block btn-success">Confirm Password</button>
                        @if (Route::has('password.request'))
                            <label class="forgot-password"><a class="" href="{{ route('password.request') }}">Forgot Password?<a></label>
                        @endif
                    </form>
                    <!-- Confirm Password form -->

                </div>
            </div>
        </div>
    </div>


</body>

</html>
