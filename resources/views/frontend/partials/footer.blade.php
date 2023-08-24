<div class="footer-area overlay overlay-black overlay-90 pb-40 pt-40 pt-lg-60">
    <div class="container">
        <div class="footer-box row mb-5" style="">
            <div class="footer-col col-12 col-lg-3 text-white" style="width: px">
                <div class="logo-footer mb-3">
                    <a href="#"><img class="f-logo" src="{{ asset('uploads/logos/' . $settings->logo_light) }}" alt="footer-logo" style="width: 60%;"></a>
                </div>
                <p class="f-text mb-3 text-justify">Pathway tries to give the best driving training to the students as a result of which the reputation of us is spread all over Bangladesh.</p>

            </div>
            <div class="footer-links col-12 col-lg-3 text-white">
                <h5 class="text-white">
                    Important Links
                </h5>
                <div class="footer-line mb-2"></div>
                <div class="row">
                    <ul class="col-6">
                        <li><a href="{{ route('index') }}">Home</a></li>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="{{ route('courses.view') }}">Courses</a></li>
                        <li><a href="{{ route('enroll.index') }}">Enroll Now</a></li>
                        <li><a href="{{ route('contact') }}">Contact Us</a></li>
                    </ul>
                    <ul class="col-6">
                        <li><a href="{{ route('blogs.view') }}">Blogs</a></li>
                        <li><a href="{{ route('privacy.policy') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('terms.conditions') }}">Terms and Conditions</a></li>
                        <li><a href="{{ route('refund.policy') }}">refund Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-links footer-contacts col-12 col-lg-3 text-white">
                <h5 class="text-white">
                    Contact us
                </h5>
                <div class="footer-line mb-2"></div>
                <ul class="" style="width: 80%">
                    <li>
                        <i class="fa fa-home"></i>
                        <span>{{ $settings->head_office }}</span>
                    </li>
                    <li>
                        <i class="fa fa-phone"></i>
                        <span> {{ $settings->phone }} </span>
                    </li>
                    <li>
                        <i class="fa fa-envelope"></i>
                        <span>{{ $settings->email }}</span>
                    </li>
                </ul>
            </div>
            <div class="certificates col-12 col-lg-3 text-white">
                <h5 class="text-white">Certified By</h5>
                <div class="footer-line mb-3"></div>
                <div class="certificate-logos d-flex">
                    @foreach ($certified_by_parts as $certified_by_part)
                        <img class="certificate-logo" src="{{ asset('assets/frontend/img/footer/' . $certified_by_part->certificate_image) }}" alt="{{ $certified_by_part->certificate_image }}" style="width: 55px;">
                    @endforeach
                </div>

                <div class="certificate-verify mt-4">
                    <h6 class="text-white mb-3">Verify Course Certifiacate</h6>
                    <form action="{{ route('certificate.verify') }}" method="POST">
                        @csrf
                        <div class="mb-2 p-0">
                            <input type="text" class="mt-1 form-control @error('certificate_id')is-invalid @enderror" name="certificate_id" value="{{ old('certificate_id') }}" width="80%" placeholder="Enter The Certificate ID" required>
                            @error('certificate_id')
                                <div class="invalid-feedback text-warning">{{ $message }}</div>
                            @enderror
                        </div>
                        <button class="btn btn-sm btn-sm mt-2 text-center">Verify</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="footer-wrappre-3 text-center col-12">
                <div class="footer-3-social mb-3">
                    <a href="{{ $settings->facebook_page }}"><i class="icofont icofont-social-facebook"></i></a>
                    <a href="{{ $settings->youtube_channel }}"><i class="icofont icofont-social-youtube"></i></a>
                    <a href="{{ $settings->linkedin }}"><i class="icofont icofont-social-linkedin"></i></a>
                    <a href="{{ $settings->instagram }}"><i class="icofont icofont-social-instagram"></i></a>
                </div>
                <p class="copyright">
                    <a href="{{ route('index') }}">Pathway</a> © {{ now()->year }} | ALL Right Reserved
                    <span>Developed By <a href="//www.imbdagency.com">IMBD Agency</a></span>
                </p>

            </div>
        </div>
    </div>
</div>
