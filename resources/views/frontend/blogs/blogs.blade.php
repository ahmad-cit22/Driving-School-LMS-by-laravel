@extends('layouts.frontend')
@section('content')
    <!-- Page content-->
    <div class="container mt-50 mb-50">
        <div class="row">
            <!-- Blog entries-->
            <div class="col-lg-12">
                <!-- Featured blog post-->
                <!-- Nested row for non-featured blog posts-->
                <div class="row">
                    @foreach ($blogs as $blog)
                        <div class="col-lg-6 pb-3">

                            <!-- Blog post-->
                            @php
                                if ($blog->blog_banner_image != null) {
                                    $blog_img = $blog->blog_banner_image;
                                } else {
                                    $blog_img = 'def-image.jpg';
                                }
                            @endphp

                            <div class="single-blog card mb-4">
                                <a href="{{ route('view.blog', $blog->id) }}"><img class="card-img-top" src="{{ asset('assets/frontend/img/blog/' . $blog_img) }}" alt="{{ $blog_img }}" /></a>
                                <div class="card-body">
                                    <div class="small text-muted">{{ Carbon\Carbon::parse($blog->created_at)->format('M d, Y') }}</div>
                                    <p class="badge cat-badge bg-secondary text-decoration-none link-light text-white mb-2"> {{ $blog->blog_category }}</p>
                                    <a class="site-text-secondary blog-read-more" href="{{ route('view.blog', $blog->id) }}">
                                        <h2 class="card-title h3 site-text-primary">{{ $blog->blog_title }}</h2>
                                    </a>
                                    <a class="site-text-secondary blog-read-more" href="{{ route('view.blog', $blog->id) }}">Read more →</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row">
            <a class="btn site-bg-primary mx-auto" href="{{ route('blogs.view.all') }}">Show More →</a>
        </div>
    </div>
@endsection

@section('style')
@endsection

@section('script')
@endsection
