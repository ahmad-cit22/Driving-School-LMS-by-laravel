@extends('layouts.otp')
@section('content')
    <!-- Loading Overlay -->
    <div class="loading">
        <div class='uil-ring-css' style='transform:scale(0.79);'>
            <div></div>
        </div>
    </div>

    <div class="d-flex justify-content-center align-items-center container">
        <div class="card py-5 px-3">
            <h5 class="m-0 text-center">Mobile Number Verification</h5>
            <span class="mobile-text">Enter the code we just send on your mobile phone <b class="text-danger">{{ auth()->user()->mobile }}</b></span>
            <div class="d-flex flex-row mt-5">
                <input type="text" class="form-control otp" autofocus maxlength="1" autocomplete="otp">
                <input type="text" class="form-control otp" maxlength="1" autocomplete="otp">
                <input type="text" class="form-control otp" maxlength="1" autocomplete="otp">
                <input type="text" class="form-control otp" maxlength="1" autocomplete="otp">
            </div>
            <div class="error"></div>
            <div class="text-center mt-5">
                <span class="d-block mobile-text">Don't receive the code?</span>
                <div class="mobile-text countdown">Resend in <span id="timer">00:10</span></div>
                <span class="btn font-weight-bold text-danger resend">Resend</span>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        .error {
            color: #ea1d22;
        }

        .countdown {
            display: none;
        }

        .card {
            width: 350px;
            padding: 10px;
            border-radius: 20px;
            background: #fff;
            border: none;
            height: 350px;
            position: relative;
        }

        .container {
            height: 100vh;
        }

        body {
            background: #eee;
        }

        .mobile-text {
            color: #989696b8;
            font-size: 15px;
            text-align: center;
        }

        .form-control {
            margin-right: 12px;
        }

        .form-control:focus {
            color: #495057;
            background-color: #fff;
            border-color: #F5821F;
            outline: 0;
            box-shadow: none;
        }

        div.loading {
            z-index: 1;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
        }

        .uil-ring-css {
            margin: auto;
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 200px;
            height: 200px;
        }

        .uil-ring-css>div {
            position: absolute;
            display: block;
            width: 160px;
            height: 160px;
            top: 20px;
            left: 20px;
            border-radius: 80px;
            box-shadow: 0 6px 0 0 #ffffff;
            -ms-animation: uil-ring-anim 1s linear infinite;
            -moz-animation: uil-ring-anim 1s linear infinite;
            -webkit-animation: uil-ring-anim 1s linear infinite;
            -o-animation: uil-ring-anim 1s linear infinite;
            animation: uil-ring-anim 1s linear infinite;
        }

        @-webkit-keyframes uil-ring-anim {
            0% {
                -ms-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -ms-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -webkit-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @-webkit-keyframes uil-ring-anim {
            0% {
                -ms-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -ms-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -webkit-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @-moz-keyframes uil-ring-anim {
            0% {
                -ms-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -ms-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -webkit-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @-ms-keyframes uil-ring-anim {
            0% {
                -ms-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -ms-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -webkit-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @-moz-keyframes uil-ring-anim {
            0% {
                -ms-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -ms-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -webkit-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @-webkit-keyframes uil-ring-anim {
            0% {
                -ms-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -ms-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -webkit-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @-o-keyframes uil-ring-anim {
            0% {
                -ms-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -ms-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -webkit-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes uil-ring-anim {
            0% {
                -ms-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -ms-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -webkit-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
    </style>
@endsection

@section('script')
    <script>
        $('.otp').keyup(function(e) {
            let input = '';
            if (/\D/g.test(this.value)) {
                this.value = this.value.replace(/\D/g, '');
            }
            $('.otp').each(function() {
                if ($(this).val() != '') {
                    input += $(this).val();
                }
            });
            if ($(this).val() != '') {
                $(this).next().focus();
            }
            if (input.length == 4) {
                $('.loading').css('display', 'block');
                $('.otp').prop('disabled', true);
                $.ajax({
                    method: 'post',
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'otp': input,
                    },
                    url: "{{ route('otp.verify') }}",
                    success: function(response) {
                        $('.loading').css('display', 'none');
                        if (response.success) {
                            location.href = "{{ route('admin.index') }}";
                        } else if (response.errors) {
                            let errors = response.errors;
                            $('.error').css('padding-top', '5px');
                            $('.error').html(errors);
                        }
                    }
                });
            }
        });

        $('.resend').click(function() {
            $('.loading').css('display', 'block');
            $.ajax({
                method: 'get',
                url: "{{ route('otp.resend') }}",
                success: function(response) {
                    $('.loading').css('display', 'none');
                    start();
                    if (getCookie('started')) {
                        startTimer(time);
                        $('.countdown').css('display', 'block');
                        $('.resend').css('display', 'none');
                    }
                    Toast.fire({
                        icon: 'success',
                        title: 'OTP sent successfully',
                    });
                }
            });
        });

        var time = '02:01';
        document.getElementById('timer').innerHTML = time;

        function start() {
            setCookie('started', true, 1);
        }

        if (getCookie('started')) {
            startTimer(time);
            $('.countdown').css('display', 'block');
            $('.resend').css('display', 'none');
        }

        function startTimer(time) {
            var presentTime;
            if (getCookie('ctime')) {
                presentTime = getCookie('ctime');
            } else {
                presentTime = time;
                setCookie('ctime', time, 1);
            }
            var timeArray = presentTime.split(/[:]+/);
            var m = timeArray[0];
            var s = checkSecond((timeArray[1] - 1));
            if (s == 59) {
                m = m - 1
            }
            if (m < 0) {
                return
            }
            var rtime = m + ":" + s;
            document.getElementById('timer').innerHTML = rtime;
            if (m == 0 && s == 0) {
                $('.countdown').css('display', 'none');
                $('.resend').css('display', 'block');
                setCookie('ctime', '', -99);
                setCookie('started', false, -99);
            } else {
                setCookie('ctime', rtime, 1);
                setTimeout(startTimer, 1000);
            }
        }

        function checkSecond(sec) {
            if (sec < 10 && sec >= 0) {
                sec = "0" + sec
            }; // add zero in front of numbers < 10
            if (sec < 0) {
                sec = "59"
            };
            return sec;
        }

        function setCookie(cname, cvalue, exdays) {
            const d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            let expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

        function getCookie(cname) {
            let name = cname + "=";
            let decodedCookie = decodeURIComponent(document.cookie);
            let ca = decodedCookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
    </script>
@endsection
