@extends('layouts.frontend')
@section('content')
    <!-- Privacy Policy Area ======================================== -->
    <div id="" class="branches-area feature-area bg-gray pt-70 pb-90">
        <div class="container justify-content-center" style=" flex-wrap: wrap;">
            <!-- Section Title -->
            <div class="">
                {!! $privacy_policy->privacy_policy !!}
            </div>
        </div>
    </div>
@endsection

@section('style')
@endsection

@section('script')
@endsection
