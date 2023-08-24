<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    {!! $settings->header_meta_tags !!}
    @yield('meta_descriptions')
    <title>{{ $page_title ? $page_title . ' | ' . $settings->site_name : $settings->site_name }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('uploads/logos/' . $settings->favicon) }}">
    <!-- Fonts -->
    <link href="{{ asset('assets/frontend/fonts/lato/lato.css') }}" rel="stylesheet">
    <!-- CSS -->
    <!-- Bootstrap CSS
 ============================================ -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css') }}">
    <!-- Icon Font CSS
 ============================================ -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/icofont.css') }}">
    <!-- Plugins CSS
 ============================================ -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/plugins.css') }}">
    <!-- Select 2 CSS
 ============================================ -->
    <link href="{{ asset('assets/vendors/select2-4.1.0/select2-4.1.0-min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/select2-4.1.0/select2-4.1.0-bootstrap-5-theme.css') }}" rel="stylesheet">
    <!-- Bootstrap Datepicker CSS
    ============================================ -->
    <link href="{{ asset('assets/vendors/bootstrap-datepicker-1.9.0/bootstrap-datepicker3.min.css') }}" rel="stylesheet">
    <!-- ShortCodes CSS
 ============================================ -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/shortcode/shortcodes.css') }}">
    <!-- Style CSS
 ============================================ -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">
    <!-- Responsive CSS
 ============================================ -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/responsive.css') }}">
    <!-- Modernizer JS
 ============================================ -->
    <script src="{{ asset('assets/frontend/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    <!-- Fontawsome 6.2
 ============================================ -->
    <link href="{{ asset('assets/vendors/font-awsome-6.2.1-pro/css/all.css') }}" rel="stylesheet">

    <style>
        .pageLoader {
            background: url(../images/loader.gif) no-repeat center center;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            z-index: 9999999;
            background-color: #ffffff8c;
            display: none;

        }

        p,
        span,
        li {
            line-height: 1.6 !important;
        }

        .single-blog {
            width: 90%;
            border-radius: 7px !important;
            transition: .3s;
        }

        .single-blog img {
            height: 370px;
        }

        .single-blog:hover {
            box-shadow: 0px 4px 16px #642f002c;
        }

        .blog-read-more {
            font-size: 16px !important;
        }

        .tag-badge {
            opacity: .9;
        }

        .cat-badge {
            opacity: .8;
        }

        .course-wrapper {
            display: flex;
            justify-content: space-between;
            row-gap: 30px;
            flex-wrap: wrap;
        }

        .course-cat-img {
            transition: .4s;
            border-radius: 20px;
            position: relative;
            overflow: hidden;
            margin-bottom: 30px;
            height: 160px;
        }

        .course-cat-img img {
            border-radius: 20px;
            width: 100%;
        }

        .course-cat-overlay {
            background: {{ $settings->site_secondary_color }};
            width: 100%;
            height: 100%;
            position: absolute;
            opacity: 0;
            bottom: 0;
            transition: .4s;
        }

        .course-cat-box:hover .course-cat-overlay {
            opacity: .3;
        }

        .course-cat-box:hover .course-cat-line {
            width: 75px;
        }

        .course-cat-box:hover h4 {
            color: {{ $settings->site_secondary_color }};
        }

        .course-cat-box h4 {
            margin-top: 20px;
            transition: .4s;
        }

        .course-cat-line {
            height: 2.5px;
            width: 30px;
            background: {{ $settings->site_secondary_color }};
            transition: .5s;
        }

        .single-feature:hover {
            box-shadow: 0px 4px 16px #642f002c;
        }

        .feature-container {
            display: flex;
            /* flex-direction: column; */
            flex-wrap: wrap;

        }

        .single-feature {
            width: 28%;
            justify-content: center;
            align-items: center;
            display: flex;
            gap: 60px;
            border-radius: 7px !important;
        }

        .single-feature .icon i {
            padding-bottom: 20px;
            font-size: 70px;
        }

        .certification-row {
            margin-top: 15px;
            justify-content: center;
            gap: 20px
        }

        .certification-row img:hover {
            transform: scale(107%);
        }

        .certification-row img {
            transition: .4s;
        }

        .about-vid {
            border-radius: 12px;
            overflow: hidden;
            margin: auto;
            margin-bottom: 30px;
        }

        .director-box {
            justify-content: center;
            align-items: center;
        }

        .director-box p {
            margin-right: 40px !important;
            text-align: justify
        }

        .director-pic {
            margin-left: 70px;
            border-radius: 10px;
            box-shadow: 1px 6px 10px #00000053
        }

        .align-center {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important
        }

        .contact-form .form-control:focus {
            border-color: {{ $settings->site_primary_color }} !important;
            box-shadow: 1px 1px 5px {{ $settings->site_primary_color }};
        }

        .contact-form {
            width: 80% !important;
            margin: 40px auto 0 !important;
        }

        .single-branch p {
            margin-bottom: 5px;
        }

        .course-container {
            column-gap: 20px;
            row-gap: 70px;
            justify-content: space-around;
        }

        .single-course-box {
            width: 23%;
        }

        .course-thumb {
            position: relative;
        }

        .sale-badge {
            position: absolute;
            top: 3px;
            right: 3px;
        }

        .text-orange {
            color: {{ $settings->site_secondary_color }};
        }

        .text-ash {
            color: #88888895;
        }

        .single-course li {
            font-size: 13px;
        }

        .single-course li i {
            font-size: 15px;
        }

        .single-course .reviews i {
            font-size: 10px;
        }

        .single-course .reviews span {
            font-size: 12px;
        }

        .single-course .reviews {
            margin-bottom: 5px;
        }

        .single-course h4 {
            font-size: 20px;
            margin-bottom: 0;
        }

        .course-container .enrollBtn {
            background: #d9d9d9;

        }

        .course-container .enrollBtn:hover {
            background: {{ $settings->site_secondary_color }};
            color: #fff;
        }

        .course-container .detailsBtn {
            color: #fff;
        }

        .course-container .detailsBtn:hover {
            background: #d9d9d9;
            color: #000;
        }

        .single-course {
            transition: .3s;
            background: #f1f1f1;
            box-shadow: 1px 1px 5px #47220141;
            /* background: #fff; */
        }

        .single-course img {
            border-top-left-radius: 13px;
            border-top-right-radius: 13px;
            height: 180px;
            width: 315px;
        }

        .single-course h3 a:hover {
            color: {{ $settings->site_secondary_color }}
        }

        .single-course:hover {
            box-shadow: 2px 6px 16px #47220141;
            /* background: #fff; */
        }

        .ti-slider .single-slide.slick-center .image {
            border-color: {{ $settings->site_primary_color }} !important;
        }

        .ti-slider::before {
            background-color: {{ $settings->site_primary_color }} !important;
        }

        .single-course .button-group {
            display: flex;
            column-gap: 13px;
            justify-content: center;
            align-items: center;
        }

        .panel-title a[aria-expanded="true"] {
            background-color: {{ $settings->site_primary_color }} !important;
        }

        .gallery-image img {
            height: 180px;
        }

        .gallery-image::before {
            background-color: {{ $settings->site_primary_color }} !important;
        }

        .panel-body {
            border-color: {{ $settings->site_primary_color }} !important;
        }

        .courseBtn {
            font-size: 16px;
            padding: 2px 13px 3px;
            background: {{ $settings->site_secondary_color }};
        }

        .footer-3-social {
            display: flex;
            justify-content: center;
            gap: 15px
        }

        .footer-3-social a {
            transition: .1s;
        }

        .f-text {
            color: #9b9b9b !important;
        }

        .footer-col p {
            width: 70% !important;
        }

        .footer-col img {
            width: 45% !important;
        }

        .footer-links h4 {
            color: #fff !important;
            margin-bottom: 21px !important;
        }

        .footer-links {
            color: #9b9b9b !important;
        }

        .copyright {
            color: #757575 !important;
        }

        .footer-links li {
            margin-bottom: 5px !important;
            transition: .2s;
        }

        .footer-links li a:hover {
            color: #fff !important;
        }

        .footer-contacts i {
            margin-right: 4px !important;
        }

        .footer-contacts li {
            margin-right: 3px !important;
        }

        .footer-contacts li:hover {
            color: #fff !important;
        }

        .site-bg-primary {
            background: {{ $settings->site_primary_color }} !important;
            color: #fff;
            border-color: transparent !important;
        }

        .site-bg-primary:hover {
            border-color: #fff !important;
            background: {{ $settings->site_accent_color }} !important;
            color: #fff !important;
        }

        .site-bg-primary-hov:hover {
            border-color: #fff !important;
            background: {{ $settings->site_primary_color }} !important;
            color: #fff;
        }

        .site-bg-secondary {
            background: {{ $settings->site_secondary_color }} !important;
            color: #fff;
            border-color: transparent !important;
        }

        .site-bg-secondary-hov:hover {
            background: {{ $settings->site_secondary_color }} !important;
            color: #fff;
            border-color: transparent !important;
        }

        .site-bg-secondary:hover {
            border-color: #fff !important;
            background: {{ $settings->site_secondary_accent_color }} !important;
            color: #fff;
        }

        /* {{ $settings->site_accent_color }}  */
        .site-text-primary {
            color: {{ $settings->site_primary_color }} !important;
        }

        .site-text-primary:hover {
            color: {{ $settings->site_accent_color }} !important;
        }

        .site-text-primary-hov:hover {
            color: {{ $settings->site_primary_color }} !important;
        }

        .site-text-secondary {
            color: {{ $settings->site_secondary_color }} !important;
        }

        .site-text-secondary:hover {
            color: {{ $settings->site_secondary_accent_color }} !important;
        }

        .cta-area {
            background-color: {{ $settings->site_primary_color }} !important;
            /* color:  */
        }

        .footer-line {
            height: .5px;
            width: 50%;
            /* background: #606060; */
        }

        .certificate-logos {
            gap: 18px;
            width: 87%;
            flex-wrap: wrap;
        }

        .about-text,
        .director-text {
            font-size: 15px;
            text-align: justify;
        }



        @media only screen and (max-width: 1100px) {

            .single-feature {
                width: 45%;
            }

            .single-blog img {
                height: auto;
            }

            .single-blog {
                width: auto;
            }

        }

        @media only screen and (max-width: 730px) {

            .gallery-image img {
                height: auto !important;
            }


            .about-text,
            .director-text {
                font-size: 14px
            }

            .single-feature {
                width: 70%;
                flex-direction: column;
                gap: 8px;
                text-align: center
            }

            .single-feature .icon i {
                font-size: 85px;
            }

            .single-feature h4 {
                font-size: 24px !important;
            }

            .course-cat-img {
                height: 220px;
            }


            .course-container {
                flex-direction: column;
                row-gap: 55px !important;
                justify-content: center;
                align-items: center
            }

            .single-course-box {
                width: 60% !important;
            }

            .single-course li {
                font-size: 14px !important;
            }

            .single-course img {
                margin: auto;
                display: block;
            }

            .courseBtn {
                font-size: 18px !important;
                /* height: 40px; */
                display: inline-block;
                padding-bottom: 2px !important;
            }

            .single-course img {
                width: 100%;
            }

            .single-course .button-group {
                display: flex;
                column-gap: 10px;
                justify-content: center
            }

            .footer-box {
                gap: 30px;
            }

            .call-to-action {
                display: flex;
                flex-direction: column;
                justify-content: center;
                gap: 18px
            }

            .call-to-action h3 {
                font-size: 18px;
            }

            .call-to-action .btn {
                display: inline-block;
                width: 28%;
                margin: auto;
            }


            .director-box {
                flex-direction: column;
                gap: 30px;
                align-items: center !important;
            }

            .director-box p {
                margin-right: 0 !important;
            }

            .director-pic {
                /* margin: auto; */
                margin-left: 0 !important;
                width: 370px !important
            }

            .director-pic-box {
                display: flex;
                justify-content: center
            }

            .about-text {
                text-align: justify;
            }


            .contact-form {
                width: 100% !important;
            }


        }

        @media only screen and (min-width: 731px) and (max-width: 1200px) {

            .course-container {
                column-gap: 50px !important;
                row-gap: 55px !important;
                justify-content: center;
            }

            .single-course-box {
                width: 30% !important;
            }

            .single-course li {
                font-size: 14px !important;
            }

            .single-course img {
                margin: auto;
                display: block;
            }

            .courseBtn {
                font-size: 18px !important;
                /* height: 40px; */
                display: inline-block;
                padding-bottom: 2px !important;
            }

            .single-course img {
                width: 100%;
            }

            .single-course .button-group {
                display: flex;
                column-gap: 10px;
                justify-content: center
            }
        }
    </style>

    @yield('style')

</head>

<body>
    <div class="pageLoader" id="pageLoader"></div>
    <!-- Pre Loader
============================================ -->
    <div class="preloader">
        <div class="loading-center">
            <div class="loading-center-absolute">
                <div class="object object_one"></div>
                <div class="object object_two"></div>
                <div class="object object_three"></div>
            </div>
        </div>
    </div>
    <!-- Body main wrapper start -->
    <div class="wrapper fix">
        <!-- Header 1
============================================ -->
        @include('frontend.partials.header')

        @yield('content')

        <!-- CTA Area
============================================ -->
        <div class="cta-area pb-40 pt-40">
            <div class="container">
                <div class="row">
                    <div class="call-to-action text-left col-lg-10 col-12 mx-auto fs-6">
                        <h3 class="text-center">Get in touch with us to know more.</h3>
                        <a href="{{ route('contact') }}" class="btn transparent">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Area
============================================ -->
        @include('frontend.partials.footer')

    </div>
    <!-- Body main wrapper end -->


    <!-- JS -->

    <!-- jQuery JS
============================================ -->
    <script src="{{ asset('assets/frontend/js/vendor/jquery-1.12.0.min.js') }}"></script>
    <!-- Bootstrap JS
============================================ -->
    <script src="{{ asset('assets/frontend/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Plugins JS
============================================ -->
    <script src="{{ asset('assets/frontend/js/plugins.js') }}"></script>
    <!-- Ajax Mail JS
============================================ -->
    <script src="{{ asset('assets/frontend/js/ajax-mail.js') }}"></script>
    <!-- WOW JS
============================================ -->
    <script src="{{ asset('assets/frontend/js/wow.min.js') }}"></script>
    <!-- Select 2
============================================ -->
    <script src="{{ asset('assets/vendors/select2-4.1.0/select2-4.1.0.js') }}"></script>
    <!-- Bootstrap Datepicker JS
============================================ -->
    <script src="{{ asset('assets/vendors/bootstrap-datepicker-1.9.0/bootstrap-datepicker.min.js') }}"></script>
    <!-- Sweet Alert JS
============================================ -->
    <script src="{{ asset('assets/vendors/sweetalert-2.11/sweetalert-2.11.js') }}"></script>
    <!-- Main JS
============================================ -->
    <script src="{{ asset('assets/frontend/js/main.js') }}"></script>
    {{-- <script>
        $(window).on('beforeunload', function() {

            $('#pageLoader').show();

        });

        $(function() {

            $('#pageLoader').hide();
        })
    </script> --}}
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: "bootstrap-5",
                placeholder: 'Select an Option',
                width: '100%',
            });

            $('.datepicker').datepicker({
                startDate: new Date(Date.now() + (3600 * 1000 * 24)),
                autoclose: true,
                format: "yyyy-mm-dd"
            });

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            @if (session('success'))
                Toast.fire({
                    icon: 'success',
                    title: '{{ session('success') }}'
                })
            @endif
            @if (session('error'))
                Toast.fire({
                    icon: 'error',
                    title: '{{ session('error') }}'
                })
            @endif
            @if (session('warning'))
                Toast.fire({
                    icon: 'warning',
                    title: '{{ session('warning') }}'
                })
            @endif

        });
    </script>

    @if (session('contactSuccess'))
        <script>
            Swal.fire(
                'Done!',
                "{{ session('contactSuccess') }}",
                'success'
            )
        </script>
    @endif

    @yield('script')

</body>

</html>
