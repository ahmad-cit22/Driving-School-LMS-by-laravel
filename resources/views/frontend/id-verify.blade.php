@extends('layouts.frontend')
@section('content')
    <div class="container py-5">
        <div class="card border-0">
            <div class="card-body">
                @if ($studend_id)
                    <h1 class="text-success text-uppercase font-weight-bolder text-center"><i class="fa-regular fa-circle-check"></i> Congratulations</h1>
                    <h4 class="text-center">The student id card is found in our record.</h4>
                    <div class="row">
                        <div class="col-6-md mx-auto mt-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4-md text-center">
                                            <img style="width: 100px" src="{{ asset('uploads/users/' . $studend_id->enroll->user->image) }}">
                                        </div>
                                        <div class="col-8-md d-flex" style="gap: 10px">
                                            <div>
                                                <p class="m-0">Name</p>
                                                <p class="m-0">Student ID</p>
                                                <p class="m-0">Mobile No</p>
                                                <p class="m-0">Course</p>
                                            </div>
                                            <div>
                                                <p class="m-0">:</p>
                                                <p class="m-0">:</p>
                                                <p class="m-0">:</p>
                                                <p class="m-0">:</p>
                                            </div>
                                            <div>
                                                <p class="m-0">{{ $studend_id->enroll->user->name }}</p>
                                                <p class="m-0">{{ $studend_id->enroll->user->id_no }}</p>
                                                <p class="m-0">{{ $studend_id->enroll->user->mobile }}</p>
                                                <p class="m-0">{{ $studend_id->enroll->category->category_name }} - {{ $studend_id->enroll->type->type_name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    nai
                @endif

            </div>
        </div>
    </div>
@endsection
