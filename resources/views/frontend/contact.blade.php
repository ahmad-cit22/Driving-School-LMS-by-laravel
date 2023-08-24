@extends('layouts.frontend')

@section('style')
    <style>
        @media only screen and (max-width: 730px) {
            .send-btn-box {
                justify-content: center !important;
            }

        }
    </style>
@endsection

@section('content')
    <!-- Branches Area ======================================== -->
    <div id="" class="branches-area feature-area bg-gray pt-70 pb-90">
        <div class="container justify-content-center" style=" flex-wrap: wrap;">
            <!-- Section Title -->
            <div class="row">
                <div class="text-center col-12 mb-45">
                    <h2 class="mb-3 heading">{{ $branch_content->title }}</h2>
                    <div class="excerpt">
                        <p>{{ $branch_content->subtitle }}</p>
                    </div>
                    <i class="icofont icofont-traffic-light  site-text-primary"></i>
                </div>
            </div>
            <div class="row mt-2 feature-container text-center" style="justify-content: center; row-gap: 50px; column-gap: 30px">
                @foreach ($branches as $branch)
                    <div class="single-branch single-feature p-4 rounded-lg">
                        <div class="text fix">
                            <h3 class="">{{ $branch->branch_name }} Branch</h3>
                            <p> <span class="" style="font-weight: bold">Tel:</span> {{ $branch->phone }}</p>
                            <p> <span class="" style="font-weight: bold">Email:</span> {{ $branch->email }}</p>
                            <p> <span class="" style="font-weight: bold">Address:</span> {{ $branch->branch_address }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- contact-area ======================================== -->
    <div class="contact-area overlay overlay-white overlay-90 pt-60 pb-60">
        <div class="container">
            <!-- Section Title -->
            <div class="row">
                <div class="section-title text-center col-12 mb-45">
                    <h2 class="mb-3 heading text-center">{{ $contact_content->title }}</h2>
                    <div class="excerpt">
                        <p>{{ $contact_content->subtitle }}</p>
                    </div>
                    <i class="icofont icofont-traffic-light  site-text-primary"></i>
                </div>
            </div>
            <div class="row text-center px-5 align-center">
                <div class="call-btn">
                    <a href="tel:{{ $settings->phone }}" class="btn site-bg-primary site-bg-secondary-hov fs-5"> <i class="fas fa-phone-volume mr-2"></i> Call Now</a>
                </div>
                <div class="contact-form-box">
                    <form action="{{ route('contact.mail') }}" method="POST" class="contact-form row mt-5">
                        @csrf
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <input type="text" class="form-control" placeholder="Name" name="name" value="" required />
                                @error('name')
                                    <strong class="text-danger text-left" style="display: block">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group mb-3">
                                <input type="email" class="form-control" placeholder="Email" name="email" value="" required />
                                @error('email')
                                    <strong class="text-danger text-left" style="display: block">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group mb-3">
                                <input type="number" class="form-control" placeholder="Mobile Number" name="number" value="" required />
                                @error('number')
                                    <strong class="text-danger text-left" style="display: block">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <input type="text" class="form-control" placeholder="Subject" name="subject" value="" required />
                                @error('subject')
                                    <strong class="text-danger text-left" style="display: block">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <textarea class="form-control" name="message" id="" cols="30" rows="7" placeholder="Write Your Message Here"required></textarea>
                                @error('message')
                                    <strong class="text-danger text-left" style="display: block">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3 row justify-content-center">
                                <input type="checkbox" id="contact-agreement" class="mb-2 mr-2 form-check" name="contact-agreement" required /><label class="" for="contact-agreement">I agree with the <a href="{{ route('terms.conditions') }}" class="site-text-primary">Terms of Use</a> and <a href="{{ route('privacy.policy') }}" class="site-text-primary">Privacy Policy</a> and I declare that I have read the information that is .</label>
                                @error('contact-agreement')
                                    <strong class="text-danger text-left" style="display: block">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>


                        <div class="col-12 mt-2 send-btn-box" style="display: flex; justify-content: right;">
                            <button class="btn site-bg-primary site-bg-secondary-hov">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- map-area ======================================== -->
    <div class="">
        <div class="pt-5 row">
            <div class="section-title text-center col-12 mb-45">
                <h2 class="mb-3 heading text-center">Locate Us on Google Map</h2>
                <i class="icofont icofont-traffic-light  site-text-primary"></i>
            </div>
        </div>
        <iframe src="{{ $settings->google_map_link }}" width="100%" height="450" style="border:0;" allowfullscreen="true" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

    {{-- <!-- Modal -->
    <div class="modal fade" id="login-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div> --}}
@endsection

@section('style')
@endsection

@section('script')
@endsection
