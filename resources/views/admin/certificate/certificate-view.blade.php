@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12 col-md-10">
            <div class="certificate-box">
                <div class="certificate-id">
                    <p>Certificate ID: {{ $certificate->certificate_id }}</p>
                </div>

                <div class="logo">
                    <img src="{{ asset('uploads/logos/' . $settings->logo_dark) }}" width="160" alt="" />
                </div>

                <h2 class="name">{{ $enroll->user->name }}</h2>

                <div class="bottom-text">
                    <p>Who has successfully completed</p>
                    <p class="fs-6 course-type">The {{ $enroll->type->type_name }} of </p>
                    <p class="course-title">{{ $enroll->category->category_name }}</p>
                    <p class="company-name">
                        From Pathway Driving Training School,
                    </p>
                    <p class="branch-name">{{ $enroll->branch->branch_name }} Branch, Bangladesh</p>
                </div>

                <div class="signatures">
                    <div class="left">
                        <div class="sign" style="position: absolute; bottom: 19.5%; left:  24%;">
                            <img src="{{ asset('uploads/signature/' . $enroll->branch->branch_manager_signature) }}" width="110" alt="" />
                        </div>
                        <div class="designation" style="position: absolute; bottom: 16.6%; left: 20.3%;">Signature of Branch Manager</div>
                    </div>

                    <div class="right">
                        <div class="sign" style="position: absolute; bottom: 19.5%; right:  24%;">
                            <img src="{{ asset('uploads/signature/signature-1-64213ab0a18c5.png') }}" width="110" alt="" />
                        </div>
                        <div class="designation" style="position: absolute; bottom: 16.6%; right: 21.9%;">Signature of Chairman</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-2">
            <a class="btn site-bg-primary text-white mt-3" href="{{ route('admin.certificate.generate', $enroll->id) }}">
                Generate PDF
            </a>
        </div>
    </div>
@endsection

@section('style')
    <style>
        .certificate-id {
            position: absolute;
            top: 13.3%;
            left: 13.5%;
            font-size: 12.5px;
            font-family: "Poppins", sans-serif;
            color: #1c1c1c;
        }

        .certificate-box {
            background: url({{ asset('assets/frontend/img/certificate-bg/1.png') }});
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 210mm;
            width: 297mm;
            text-align: center;
            position: relative;
        }

        .logo {
            position: absolute;
            top: 16.5%;
            left: 43.3%;
        }

        .certificate-box .name {
            width: 405px;
            position: absolute;
            top: 52.8%;
            left: 32.5%;
            text-align: center;
            font-family: "Tangerine", cursive;
            font-size: 55px;
            font-weight: normal;
            word-spacing: 4px;
        }

        .certificate-box .bottom-text {
            width: 405px;
            position: absolute;
            top: 61%;
            left: 33%;
            text-align: center;
            font-family: "Poppins", sans-serif;
            word-spacing: 2px;
            font-size: 12px;
            font-weight: normal;
        }

        .bottom-text p {
            margin: 6px 0;
        }

        .course-title {
            font-size: 17px;
            font-weight: 600;
        }

        .company-name {
            font-size: 13px;
        }

        .branch-name {
            font-size: 12px;
        }

        .signatures {
            /* position: relative; */
            /* bottom: 16%; */
            width: 57.8% !important;
            /* left: 20.3%; */
            text-align: center;
            word-spacing: 2px;
            font-size: 12px;
            font-weight: normal;
        }

        .designation {
            font-family: "Poppins", sans-serif;
            font-size: 12px;
            margin-top: 9px;
        }

        .left,
        .right {
            margin-top: 10px;
        }

        .course-type {
            font-size: 14px !important;
        }
    </style>
@endsection
