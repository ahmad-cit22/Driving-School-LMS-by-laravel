@extends('layouts.frontend')

@section('meta_descriptions')
    <meta name="description" content="{{ $single_course->meta_description }}" />
    <meta property="og:image" content="{{ asset('assets/frontend/img/courses/' . $single_course->image) }}" />
@endsection

@section('style')
    <style>
        .course-details-img {
            width: 500px;
        }

        .course-details-btn {
            display: inline-block;
            width: 20%;
            font-size: 15px
        }


        .course-details-text {
            padding-top: 0;
        }


        @media only screen and (max-width: 730px) {
            .course-details-img {
                width: auto;
            }


            .course-details-text {
                padding: 0;
            }

            .course-details-btn {
                display: inline-block;
                width: 50%;
                font-size: 16px !important;
                margin-bottom: 5px;
                height: 35px;
            }

            .course-details-text {
                padding-top: 5%;
            }
        }
    </style>
@endsection

@section('content')
    {{-- course details --}}
    <div id="course-area" class="course-area bg-white pt-90 pb-60">
        <div class="container">
            <h3 class="site-text-primary mb-4">Course Details</h3>

            <div class="px-2 mb-5" style="">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <img class="course-details-img" src="{{ asset('assets/frontend/img/courses/' . $single_course->image) }}" class="img-responsive" alt="{{ $single_course->image }}">
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="card-body course-details-text">
                            <h3 class="card-title">{{ $single_course->rel_to_course_cat->category_name . ' - ' . $single_course->rel_to_course_type->type_name }}</h3>
                            <p class="reviews pt-1 mb-1">
                                @php
                                    $category = $single_course->category_id;
                                    $type = $single_course->type_id;
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
                            <div class="pt-2" style="padding-bottom: 15px; display: flex; flex-direction: column; justify-content: space-between;">
                                <ul>
                                    <li>Course Duration: <span class="fw-bold">{{ $single_course->rel_to_course_type->duration . ' Days' }}</span></li>
                                </ul>
                                <h4 class="site-text-primary" style="font-weight: 600">
                                    @if ($single_course->discount)
                                        <del class="text-muted" style="font-size: 17px">BDT {{ number_format($single_course->price) }}</del>
                                        <p>BDT {{ number_format($single_course->after_discount) }}</p>
                                    @else
                                        BDT {{ number_format($single_course->after_discount) }}
                                    @endif
                                </h4>
                                <a href="{{ route('enroll.index') }}" class="btn course-details-btn mt-3 courseBtn enrollBtn site-bg-primary" style="border-radius: 4px;">Enroll Now</a>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="mt-4">
                <h5 class="site-text-primary">More Details:</h5>
                @if ($single_course->course_details != null)
                    {!! $single_course->course_details !!}
                @else
                    No details found about this course.
                @endif

                </p>

                <a href="{{ route('enroll.index') }}" class="btn mt-3 courseBtn enrollBtn site-bg-primary" style="border-radius: 4px;">Enroll Now</a>
            </div>
        </div>


        {{-- paid courses area  --}}
        <div id="" class="courses-area bg-gray pt-60 pb-60">
            <div class="container justify-content-center" style=" flex-wrap: wrap;">
                <!-- Section Title -->
                <div class="row">
                    <div class="text-center col-12 mb-45">
                        <h2 class="mb-3 heading">Other Courses</h2>
                        <i class="icofont icofont-traffic-light  site-text-primary"></i>
                    </div>
                </div>
                <div class="row mt-2 course-container">
                    @foreach ($courses as $key => $course)
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

    @section('style')
    @endsection

    @section('script')
    @endsection
