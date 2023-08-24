<div class="header-area header-absolute header-transparent">
    <div class="header-bottom sticky">
        <div class="container">
            <div class="row justify-content-between">
                <div class="navbar-header col-auto">
                    <a href="{{ route('index') }}" class="logo navbar-brand"><img id="logo_img" src="{{ asset('assets/frontend/img/logo/' . App\Models\BannerPart::all()->first()->logo_image) }}" alt="logo"></a>
                </div>
                <div class="main-menu mean-menu col-auto">
                    <nav style="display: block;">
                        <ul>
                            <li><a href="{{ route('index') }}">Home</a></li>
                            <li><a href="{{ route('about') }}">About Us</a></li>
                            <li><a href="{{ route('courses.view') }}">Courses</a></li>
                            <li>
                                <a href="javascript:void(0);">Enroll Now <i class="icofont icofont-simple-down"></i></a>
                                <ul>
                                    <li><a href="{{ route('enroll.index') }}">Offline Courses</a></li>
                                    <li><a href="{{ route('enroll.vid_course.index') }}">Online Courses (Free)</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('blogs.view') }}">Blogs</a></li>
                            <li>
                                <a href="javascript:void(0);">Get in Touch <i class="icofont icofont-simple-down"></i></a>
                                <ul>
                                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                                    <li><a href="{{ route('privacy.policy') }}">Privacy Policy</a></li>
                                    <li><a href="{{ route('terms.conditions') }}">Terms & Conditions</a></li>
                                    <li><a href="{{ route('refund.policy') }}">Refund Policy</a></li>
                                </ul>
                            </li>
                            @auth
                                <li>
                                    <a href="javascript:void(0);">My Account <i class="icofont icofont-simple-down"></i></a>
                                    <ul>

                                        <li><a href="{{ route('admin.index') }}">Dashboard</a></li>
                                        <li><a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                        </li>
                                    </ul>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            @else
                                <li><a href="{{ route('login') }}">Login</a></li>
                                <li><a href="{{ route('register') }}">Register</a></li>
                            @endauth
                        </ul>
                    </nav>
                </div>
                <div class="mobile-menu col-12"></div>
            </div>
        </div>
    </div>
</div>

<!-- Page Banner Area -->
@if (Request::route()->getName() != 'index')
    @include('frontend.partials.banner')
@endif
