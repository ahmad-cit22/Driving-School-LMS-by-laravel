@extends('layouts.frontend')

@section('style')
    <style>
        @media only screen and (max-width: 990px) {
            .form-control {
                width: 63% !important;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Hero Slide Area ========================================= -->
    <div class="hearo-area hero-static overlay overlay-black overlay-60 fix" data-parallax="scroll" data-bleed="10" data-speed="0.5" data-image-src="{{ asset('assets/frontend/img/banners/' . $banner_part->banner_img) }}">
        <div class="container">
            <div class="hero-slide-content text-left">
                <h3>{{ $banner_part->subtitle }}</h3>
                <h1 style="width: 70%"><span class="">{{ $banner_part->title }}</span></h1>
                <p style="width: 500px">{{ $banner_part->bottom_text }}</p>
                <div class="button-group">
                    <a href="{{ $banner_part->button_one_link == '' ? route('courses.view') : $banner_part->button_one_link }}" class="btn transparent">{{ $banner_part->button_one_name }}</a>
                    <a href="{{ $banner_part->button_two_link == '' ? route('about') : $banner_part->button_two_link }}" class="btn site-bg-primary">{{ $banner_part->button_two_name }}</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Feature Area ======================================== -->
    <div id="feature-area" class="feature-area bg-gray pt-90 pb-90">
        <div class="container justify-content-center" style=" flex-wrap: wrap;">
            <!-- Section Title -->
            <div class="row">
                <div class="text-center col-12 mb-45">
                    <h2 class="mb-3 heading">{{ $featurePart->title }}</h2>
                    <div class="excerpt">
                        <p>{{ $featurePart->subtitle }}</p>
                    </div>
                    <i class="icofont icofont-traffic-light  site-text-primary"></i>
                </div>
            </div>
            <div class="row mt-2 feature-container" style="justify-content: space-between; row-gap: 50px;">
                @foreach ($features as $feature)
                    <div class="single-feature p-4 rounded-lg">
                        <div class="icon"><i class="{{ $feature->icon }} site-text-primary"></i></div>
                        <div class="text fix">
                            <h4 class="">{{ $feature->title }}</h4>
                            <p>{{ $feature->text }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Funfact Area ============================================ -->
    <div class="funfact-area overlay overlay-white overlay-80 pt-90 pb-60">
        <div class="container">
            <div class="row">
                @foreach ($counters as $counter)
                    <div class="single-facts text-center col-md-3 col-sm-6 col-12 mb-30">
                        <i class="{{ $counter->icon }}"></i>
                        <h1 class="counter {{ $counter->amount > 100 ? 'plus' : '' }}">{{ $counter->amount }}</h1>
                        <p>{{ $counter->text }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Course Category -->
    <div id="course-area" class="course-area bg-gray pt-90 pb-60">
        <div class="container">
            <!-- Section Title -->
            <div class="row">
                <div class="text-center col-12 mb-45">
                    <h2 class="mb-3 heading">Course Categories</h2>
                    <i class="icofont icofont-traffic-light  site-text-primary"></i>
                </div>
            </div>
            <!-- Course Wrapper -->
            <div class="course-wrapper row justify-content-center">
                @foreach ($categories as $category)
                    <div class="col-lg-3 col-md-6 col-12 mb-30 fix">
                        <div class="text-center course-cat-box" style="">
                            <div class="course-cat-img">
                                <img class="" src="{{ asset('assets/frontend/images/category/' . $category->image) }}" alt="">
                                <div class="course-cat-overlay">
                                </div>
                            </div>
                            <div class="course-cat-line mx-auto mt-4"></div>
                            <div class="mt-3 pb-20 course-cat-text">
                                <h4 class="fw-bold">{{ $category->category_name }}</h4>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Video Area ============================================ -->
    <div class="video-area overlay overlay-black overlay-50">
        <div class="container">
            <div class="row">
                <div class="video-content text-center col-12">
                    <a class="video-popup" href="{{ $video->link }}"><i class="icofont icofont-play-alt-2 site-text-primary-hov"></i></a>
                    <h3>{{ $video->title }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- paid courses area  --}}
    <div id="" class="courses-area bg-gray pt-60 pb-60">
        <div class="container justify-content-center" style=" flex-wrap: wrap;">
            <!-- Section Title -->
            <div class="row">
                <div class="text-center col-12 mb-45">
                    <h2 class="mb-3 heading">Our Courses</h2>
                    <i class="icofont icofont-traffic-light  site-text-primary"></i>
                </div>
            </div>
            <div class="row mt-2 course-container">
                @forelse ($courses as $key => $course)
                    <div class="single-course-box">
                        <div class="single-popular single-course" style="border-radius: 9px; ">
                            <div class="mx-auto course-thumb" style="margin-bottom: 20px;">
                                <a href="{{ route('course.details', $course->id) }}"><img src="{{ asset('assets/frontend/img/courses/' . $course->image) }}" class="img-responsive" alt=""></a>
                                @if ($course->discount)
                                    <span class="sale-badge badge badge-success site-bg-secondary">{{ $course->discount }}% Off!</span>
                                @endif

                            </div>
                            <div class="popular-course-content text-center">
                                <h4 class="" style="font-weight: 700"><a href="{{ route('course.details', $course->id) }}">{{ $course->rel_to_course_cat->category_name . ' - ' . $course->rel_to_course_type->type_name }}</a></h4>
                                <p class="reviews pt-1">
                                    @php
                                        $category = $course->category_id;
                                        $type = $course->type_id;
                                        $enrolls = App\Models\Enroll::where('course_category', $category)->where('course_type', $type);
                                        $review_count = 0;
                                        $review_star = 0;
                                        
                                        if ($enrolls->exists()) {
                                            // print_r($enrolls->get());
                                            foreach ($enrolls->get() as $enroll) {
                                                $review = App\Models\Review::where('enrollment_id', $enroll->id);
                                                if ($review->exists()) {
                                                    $review_count += 1;
                                                    $star = $review->get()->first()->review;
                                                    $review_star += $star;
                                                }
                                            }
                                        
                                            $avg_review = $review_count == 0 ? 0 : number_format($review_star / $review_count);
                                        }
                                    @endphp
                                    {{-- review : {{ $review_count != 0 ? $avg_review : 0 }} --}}
                                    @if ($review_count != 0)
                                        @for ($i = 0; $i < $avg_review; $i++)
                                            <i class="fa text-orange fa-star"></i>
                                        @endfor
                                        @for ($i = 0; $i < 5 - $avg_review; $i++)
                                            <i class="fa text-ash fa-star"></i>
                                        @endfor
                                    @else
                                        <i class="fa text-orange fa-star"></i>
                                        <i class="fa text-orange fa-star"></i>
                                        <i class="fa text-orange fa-star"></i>
                                        <i class="fa text-orange fa-star"></i>
                                        <i class="fa text-ash fa-star"></i>
                                    @endif

                                    {{-- <span class="review-count">{{ $review_count }} Reviews</span> --}}
                                </p>
                                <div class="pt-2" style="padding-bottom: 25px; display: flex; flex-direction: column; justify-content: space-between; height: 150px;">
                                    <ul>
                                        <li><i class="fa text-orange fa-caret-right mb-2" style="margin-right: 6px;"></i>Course Duration: <span class="fw-bold">{{ $course->rel_to_course_type->duration . ' Days' }}</span></li>
                                    </ul>
                                    <h4 class="site-text-primary" style="font-weight: 600">
                                        @if ($course->discount)
                                            <del class="text-muted" style="font-size: 17px">BDT {{ number_format($course->price) }}</del>
                                            <p>BDT {{ number_format($course->after_discount) }}</p>
                                        @else
                                            BDT {{ number_format($course->after_discount) }}
                                        @endif
                                    </h4>

                                    <div class="button-group mt-3">
                                        <a href="{{ route('course.details', $course->id) }}" class="courseBtn enrollBtn bg-secondary text-white" style="border-radius: 4px;">Details</a>
                                        <a href="{{ route('enroll.index') }}" class="courseBtn enrollBtn site-bg-primary" style="border-radius: 4px;">Enroll</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center">No Courses Avaliable Right Now.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Testimonial Area -->
    <div id="testimonial-area" class="testimonial-area overlay overlay-white overlay-40 text-center pt-50 pb-90">
        <div class="container">
            <!-- Section Title -->
            <div class="row">
                <div class="section-title text-center col-12 mb-45">
                    <h2 class="mb-3 heading">Testimonials About Us</h2>
                    <i class="icofont icofont-traffic-light  site-text-primary site-text-primary"></i>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-12 mx-auto">
                    <!-- Testimonial Image Slider -->
                    <div class="ti-slider mb-40">
                        @foreach ($reviews as $review)
                            <div class="single-slide">
                                <div class="image fix"><img src="{{ $review->rel_to_enroll->user->image ? asset('uploads/users/' . $review->rel_to_enroll->user->image) : Avatar::create($review->rel_to_enroll->user->name)->toBase64() }}" alt="{{ $review->rel_to_enroll->user->name }}" /></div>
                            </div>
                        @endforeach

                    </div>
                    <!-- Testimonial Content Slider -->
                    <div class="tc-slider">
                        @foreach ($reviews as $review)
                            <div class="single-slide">
                                <p>{{ $review->review_text }}</p>
                                <h5>{{ $review->rel_to_enroll->user->name }}</h5>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Slider Arrows -->
        <button class="ts-arrows ts-prev"><i class="icofont icofont-caret-left site-text-primary-hov"></i></button>
        <button class="ts-arrows ts-next"><i class="icofont icofont-caret-right site-text-primary-hov"></i></button>
    </div>

    <!-- Gallery Area ============================================ -->
    <div id="gallery-area" class="gallery-area bg- pt-90 pb-60">
        <div class="container">
            <!-- Section Title -->
            <div class="row">
                <div class="section-title text-center col-12 mb-45">
                    <h2 class="mb-3 heading">Photo Gallery</h2>
                    <i class="icofont icofont-traffic-light  site-text-primary site-text-primary"></i>
                </div>
            </div>
            <!-- Gallery Filter -->
            <div class="gallery-filter text-center">
                <button class="active" data-filter="*">All</button>
                <button data-filter=".vehicles">Vehicles</button>
                <button data-filter=".students">Students</button>
                <button data-filter=".classrooms">Classrooms</button>
                <button data-filter=".exams">Exams</button>
            </div>
            <!-- Gallery Grid -->
            <div class="gallery-grid row">
                @foreach ($gallery_images as $gallery_image)
                    <div class="gallery-item col-lg-3 col-md-4 col-6 {{ $gallery_image->image_class }}">
                        <a href="{{ asset('assets/frontend/img/gallery/' . $gallery_image->image) }}" class="gallery-image image-popup">
                            <img src="{{ asset('assets/frontend/img/gallery/' . $gallery_image->image) }}" alt="{{ $gallery_image->image }}" />
                            <div class="content">
                                <i class="icofont icofont-search"></i>
                                <h4 class="text-capitalize">{{ $gallery_image->image_class }}</h4>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- FAQ Area ============================================ -->
    <div id="faq-area" class="faq-area bg-white pt-90 pb-60">
        <div class="container">
            <!-- Section Title -->
            <div class="row">
                <div class="section-title text-center col-12 mb-45">
                    <h2 class="mb-3 heading">Frequently Asked Questions</h2>
                    <i class="icofont icofont-traffic-light  site-text-primary"></i>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="panel-group" id="faq">
                        @foreach ($faq_questions as $key => $faq_question)
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a data-toggle="collapse" aria-expanded="{{ $key == '0' ? 'true' : 'false' }}" href="{{ '#faq-' . $key + 1 }}">{{ $faq_question->question }}</a></h4>
                                </div>
                                <div id="{{ 'faq-' . $key + 1 }}" class="panel-collapse collapse {{ $key == '0' ? 'show' : '' }}" data-parent="#faq">
                                    <div class="panel-body">
                                        <p>{{ $faq_question->answer }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="faq-image col-lg-6 col-12 pl-4">
                    <img src="{{ asset('assets/frontend/img/faq/' . $faq_image->image) }}" alt="{{ $faq_image->image }}" />
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @if (session('verifySuccess'))
        <script>
            Swal.fire({
                title: "{{ session('verifySuccess') }}",
                html: "<div class='info'> <p> <b>Certificate ID:</b> {{ session('c_id') }}</p> <p> <b>Student Name:</b> {{ session('student_name') }}</p> <p> <b>Course Category:</b> {{ session('course_category') }}</p> <p> <b>Course Type:</b> {{ session('course_type') }}</p> </div>"
            })
        </script>
    @endif

    @if (session('verifyFailed'))
        <script>
            Swal.fire(
                'Sorry!',
                "{{ session('verifyFailed') }}",
                'error'
            )
        </script>
    @endif
@endsection
