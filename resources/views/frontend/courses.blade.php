@extends('layouts.frontend')

@section('content')
    <!-- Course Category -->
    <div id="course-area" class="course-area bg-white pt-90 pb-60">
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
                                <img class="" src="{{ asset('assets/frontend/images/category/' . $category->image) }}" alt="{{ $category->image }}">
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
                                <a href="{{ route('course.details', $course->id) }}"><img src="{{ asset('assets/frontend/img/courses/' . $course->image) }}" class="img-responsive" alt="{{ $course->image }}"></a>
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

    {{-- free courses area  --}}
    <div id="" class="courses-area bg-gray pt-60 pb-60">
        <div class="container justify-content-center" style=" flex-wrap: wrap;">
            <!-- Section Title -->
            <div class="row">
                <div class="text-center col-12 mb-45">
                    <h2 class="mb-3 heading">Online Courses</h2>
                    <i class="icofont icofont-traffic-light  site-text-primary"></i>
                </div>
            </div>
            <div class="row mt-2 course-container">
                @forelse ($online_courses as $key => $online_course)
                    <div class="single-course-box">
                        <div class="single-popular single-course" style="border-radius: 9px; ">
                            <div class="mx-auto" style="margin-bottom: 20px;">
                                <img src="{{ asset('assets/frontend/img/courses/' . $online_course->image) }}" class="img-responsive" alt="">
                            </div>
                            <div class="popular-course-content text-center">
                                <h4 class="" style="font-weight: 700">{{ $online_course->course_title }}</h4>

                                <div class="pt-2" style="padding-bottom: 25px; display: flex; flex-direction: column; justify-content: space-between; height: 150px;">
                                    <ul>
                                        <li><i class="fa text-orange fa-caret-right mb-2" style="margin-right: 6px;"></i>Course Category: <span class="fw-bold">{{ $online_course->rel_to_course_cat->category_name }}</span></li>
                                        <li><i class="fa text-orange fa-caret-right mb-2" style="margin-right: 6px;"></i>Course Type: <span class="fw-bold">{{ $online_course->rel_to_course_type->type_name }}</span></li>
                                    </ul>
                                    <h4 class="site-text-primary mt-2" style="font-weight: 600">FREE</h4>
                                    <div class="button-group mt-3">
                                        <a href="{{ route('enroll.vid_course.index') }}" class="courseBtn enrollBtn site-bg-primary" style="border-radius: 4px;">Enroll</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center">No Online Courses Avaliable Right Now.</p>
                @endforelse
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

@section('style')
@endsection

@section('script')
@endsection
