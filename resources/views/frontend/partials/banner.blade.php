<div class="page-banner-area overlay overlay-black overlay-70">
    <div class="container">
        <div class="row">
            <!--breadcrumb-->
            @php
                $breadcrumbs = Request::segments();
            @endphp
            <div class="page-banner text-center col-12">
                <h1>{{ isset($page_title) ? $page_title : ucwords(end($breadcrumbs)) }}</h1>
                <ul>
                    <li><a href="{{ route('index') }}">home</a></li>
                    @foreach ($breadcrumbs as $breadcrumb)
                        <li><span style="line-height: 9px !important">{{ ucwords(str_replace(['_', '-'], ' ', $breadcrumb)) }}</span></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
