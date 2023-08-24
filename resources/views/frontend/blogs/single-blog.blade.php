@extends('layouts.frontend')
@php
    if ($blog->blog_banner_image != null) {
        $blog_img = $blog->blog_banner_image;
    } else {
        $blog_img = 'def-image.jpg';
    }
@endphp
@section('meta_descriptions')
    <meta name="description" content="{{ $blog->meta_description }}" />
    <meta property="og:image" content="{{ asset('assets/frontend/img/blog/' . $blog_img) }}" />
@endsection

@section('style')
    <style>
        .share-btns {
            gap: 8px;
        }

        .share-btns i {
            font-size: 18px
        }

        .fa-share {
            font-size: 14px !important
        }

        .blog_post_box ul {
            list-style-type: disc !important;
        }

        .blog_post_box {
            /* line-height: 100px !important; */
        }
    </style>
@endsection

@section('content')
    <!-- Page content-->
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-11 mx-auto">
                <!-- Post content-->
                <article>
                    <!-- Post header-->
                    <header class="mb-4">
                        <!-- Post title-->
                        <h1 class="fw-bolder mb-1">{{ $blog->blog_title }}</h1>

                        <!-- Post meta content-->
                        <div class="text-muted fst-italic mb-2">Posted on {{ Carbon\Carbon::parse($blog->created_at)->format('M d, Y') }}</div>
                        <!-- Post categories-->
                        <p class="cat-badge text-decoration-none mb-1" style="font-style: italic;">Category: {{ $blog->blog_category }}</p>
                        {{-- tags --}}
                        @if ($blog->blog_tags->count() > 0)
                            <div> Tags:
                                @foreach ($blog->blog_tags as $blog_tag)
                                    <a href="{{ route('blogs.filter.view', $blog_tag->tag->id) }}"><span class="ml-1 tag-badge badge bg-secondary text-white">{{ $blog_tag->tag->tag_name }}</span></a>
                                @endforeach
                            </div>
                        @endif

                        {{-- Social Media Share btns --}}
                        <div class="share-btns mt-2 row pl-3">
                            <span class="mb-2 mr-1"><i class="fas fa-share mr-1"></i>Share on Social Media:</span>
                            <a class="fs-1" href="https://www.facebook.com/sharer/sharer.php?u={{ Request::url() }}" target="_blank"><i class="fab fa-facebook-square"></i></a>
                            <a href="https://twitter.com/intent/tweet?url={{ Request::url() }}&text={{ $blog->blog_title }}" target="_blank"><i class="fab fa-twitter-square"></i></a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ Request::url() }}&title={{ $blog->blog_title }}" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
                            <a href="mailto:?subject={{ $blog->blog_title }}&body=Check%20out%20this%20blog%20post:%20{{ Request::url() }}"><i class="fa-solid fa-envelope"></i></a>
                            <a href="https://www.reddit.com/submit?url={{ Request::url() }}&title={{ $blog->blog_title }}" target="_blank"><i class="fa-brands fa-square-reddit"></i></a>
                        </div>


                        {{-- <div id="social-share">
                            <strong><span>Sharing is caring</span></strong> <i class="fa fa-share-alt"></i>&nbsp;&nbsp;
                            <a href="https://www.facebook.com/sharer.php?u='.$url.'" target="_blank" class="facebook"><i class="fa fa-facebook"></i> <span>Share</span></a>
                            <a href="https://plus.google.com/share?url='.$url.'" target="_blank" class="gplus"><i class="fa fa-google-plus"></i> <span>+1</span></a>
                            <a href="https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url.'&amp;via=YOUR_TWITTER_HANDLE_HERE" target="_blank" class="twitter"><i class="fa fa-twitter"></i> <span>Tweet</span></a>
                            <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url='.$title.'" target="_blank" class="linkedin"><i class="fa fa-linkedin"></i> <span>Share</span></a>
                            <a href="whatsapp://send?text='.$title.' '.$url.'" target="_blank" class="whatsapp"><i class="fa fa-whatsapp"></i> <span>Share</span></a>
                        </div>' --}}

                    </header>


                    <!-- Preview image figure-->
                    <figure class="mb-4"><img class="img-fluid rounded" src="{{ asset('assets/frontend/img/blog/' . $blog_img) }}" alt="{{ $blog_img }}" style="width: 1125px" /></figure>
                    <!-- Post content-->
                    <section class="mb-5 blog_post_box">
                        {!! $blog->blog_post !!}
                    </section>
                </article>
            </div>
            <!-- Side widgets-->
            {{-- <div class="col-lg-4">
                    <!-- Search widget-->
                    <div class="card mb-4">
                        <div class="card-header">Search</div>
                        <div class="card-body">
                            <div class="input-group">
                                <input class="form-control" type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                                <button class="btn btn-primary" id="button-search" type="button">Go!</button>
                            </div>
                        </div>
                    </div>
                    <!-- Categories widget-->
                    <div class="card mb-4">
                        <div class="card-header">Categories</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <ul class="list-unstyled mb-0">
                                        <li><a href="#!">Web Design</a></li>
                                        <li><a href="#!">HTML</a></li>
                                        <li><a href="#!">Freebies</a></li>
                                    </ul>
                                </div>
                                <div class="col-sm-6">
                                    <ul class="list-unstyled mb-0">
                                        <li><a href="#!">JavaScript</a></li>
                                        <li><a href="#!">CSS</a></li>
                                        <li><a href="#!">Tutorials</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Side widget-->
                    <div class="card mb-4">
                        <div class="card-header">Side Widget</div>
                        <div class="card-body">You can put anything you want inside of these side widgets. They are easy to use, and feature the Bootstrap 5 card component!</div>
                    </div>
                </div> --}}
        </div>
    </div>
@endsection

@section('style')
@endsection

@section('script')
@endsection
