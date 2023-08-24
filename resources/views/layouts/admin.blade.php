<!doctype html>
<html lang="en" class="semi-dark">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href='{{ asset('uploads/logos/' . $settings->favicon) }}' type="image/png" />
    <!--plugins-->
    <link href="{{ asset('assets/backend') }}/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="{{ asset('assets/backend') }}/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="{{ asset('assets/backend') }}/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <link href="{{ asset('assets/backend') }}/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/backend') }}/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ asset('assets/backend') }}/css/bootstrap-extended.css" rel="stylesheet" />
    <link href="{{ asset('assets/backend') }}/css/style.css" rel="stylesheet" />
    <link href="{{ asset('assets/backend') }}/css/icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Tangerine&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    {{-- <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet"> --}}

    <!-- icons-->
    <link href="{{ asset('assets/vendors/bootstrap-icon-1.9.1/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/font-awsome-6.2.1-pro/css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/select2-4.1.0/select2-4.1.0-min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/select2-4.1.0/select2-4.1.0-bootstrap-5-theme.css') }}" rel="stylesheet">

    <!-- loader-->
    <link href="{{ asset('assets/backend') }}/css/pace.min.css" rel="stylesheet" />

    <!--Theme Styles-->
    <link href="{{ asset('assets/backend') }}/css/semi-dark.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .tag-badge {
            opacity: .7;
        }

        .table-responsive::-webkit-scrollbar {
            -webkit-appearance: none;
        }

        .table-responsive::-webkit-scrollbar:vertical {
            width: 12px;
        }

        .table-responsive::-webkit-scrollbar:horizontal {
            height: 12px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background-color: rgba(1, 0, 84, 0.585);
            border-radius: 10px;
            border: 2px solid #ffffff;
        }

        .table-responsive::-webkit-scrollbar-track {
            border-radius: 10px;
            background-color: #ffffff;
        }

        #p-card {
            background: url({{ asset('assets/frontend/images/1.png') }}) !important;
            background-size: cover;
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

        .asdasd {}
    </style>

    @yield('style')

    <title>Dashboard | Pathway Driving Training School</title>
</head>

<body>


    <!--start wrapper-->
    <div class="wrapper">
        <!--start top header-->
        @include('admin.partials.navbar')
        <!--end top header-->

        <!--start sidebar -->
        @include('admin.partials.sidebar')
        <!--end sidebar -->

        <!--start content-->
        <main class="page-content">
            <!--breadcrumb-->
            @php
                $breadcrumbs = Request::segments();
            @endphp
            <div class="page-breadcrumb d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">{{ isset($page_title) ? $page_title : ucwords(end($breadcrumbs)) }}
                </div>
                <div class="ps-sm-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            @foreach ($breadcrumbs as $breadcrumb)
                                @if (Request::route()->getName() == 'admin.users.edit' && is_numeric($breadcrumb))
                                    <li class="breadcrumb-item" aria-current="page">{{ $user->name }}</li>
                                @else
                                    <li class="breadcrumb-item" aria-current="page">
                                        {{ ucwords(str_replace(['_', '-'], ' ', $breadcrumb == 'admin' ? 'dashboard' : $breadcrumb)) }}
                                    </li>
                                @endif
                            @endforeach
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    @yield('top-btn')
                </div>
            </div>
            <!--end breadcrumb-->
            @yield('content')
        </main>
        <!--end page main-->

        <!--start overlay-->
        <div class="overlay nav-toggle-icon"></div>
        <!--end overlay-->

        <!--Start Back To Top Button-->
        <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->

    </div>
    <!--end wrapper-->

    {{-- <script src="sweetalert2.all.min.js"></script> --}}
    <!-- Bootstrap bundle JS -->
    <script src="{{ asset('assets/backend') }}/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="{{ asset('assets/backend') }}/js/jquery.min.js"></script>
    <script src="{{ asset('assets/backend') }}/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="{{ asset('assets/backend') }}/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="{{ asset('assets/backend') }}/js/pace.min.js"></script>
    <script src="{{ asset('assets/backend') }}/plugins/datatable/js/jquery.dataTables.min.js"></script>
    {{-- <script src="{{ asset('assets/backend') }}/plugins/datatable/js/dataTables.bootstrap5.min.js"></script> --}}
    <script src="{{ asset('assets/backend') }}/js/table-datatable.js"></script>
    <script src="{{ asset('assets/backend') }}/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="{{ asset('assets/vendors/sweetalert-2.11/sweetalert-2.11.js') }}"></script>
    <script src="{{ asset('assets/vendors/select2-4.1.0/select2-4.1.0.js') }}"></script>
    <script src="{{ asset('assets/vendors/fullcalendar-6.0.3/dist/index.global.min.js') }}"></script>

    {{-- summernote --}}
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <!--app-->
    <script src="{{ asset('assets/backend') }}/js/app.js"></script>
    <script>
        $('.select2').select2({
            theme: "bootstrap-5",
            placeholder: 'Select an Option',
            width: '100%',
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

        function delete_warning(url) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }

        function warning(url) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, do it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
    </script>

    @if (session('participationError'))
        <script>
            Swal.fire(
                'Sorry',
                "{{ session('participationError') }}",
                'error',
            )
        </script>
    @endif

    @if (session('dltErr'))
        <script>
            Swal.fire(
                'Sorry',
                "{{ session('dltErr') }}",
                'error',
            )
        </script>
    @endif

    @if (session('enrollSuccess'))
        <script>
            Swal.fire(
                'Done',
                "{{ session('enrollSuccess') }}",
                'success',
            )
        </script>
    @endif

    <script>
        $(document).ready(function() {
            {{ session()->forget('enrollSuccess') }}
        });
        // document.onload(function() {

        // })
    </script>

    @if (session('needToEnroll'))
        <script>
            Swal.fire(
                'Sorry',
                "{{ session('needToEnroll') }}",
                'error',
            )
        </script>
    @endif

    @if (session('errPay'))
        <script>
            Swal.fire(
                'Sorry',
                "{{ session('errPay') }}",
                'error',
            )
        </script>
    @endif

    @yield('script')

</body>

</html>
