@extends('layouts.frontend')
@section('content')
    <!-- terms_and_conditions Area ======================================== -->
    <div id="" class="branches-area feature-area terms-area bg-gray pt-70 pb-90">
        <div class="container justify-content-center" style=" flex-wrap: wrap;">
            <!-- Section Title -->
            <div class="">
                {!! $terms_and_conditions->terms_and_conditions !!}
            </div>
        </div>
    </div>
@endsection

@section('style')
@endsection

@section('script')
@endsection
