<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Tangerine&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />

    <style>
        @page {
            margin: 0px;
        }

        body {
            margin: 0px;
        }

        .certificate-id {
            position: absolute;
            top: 11%;
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
            width: 400px;
            margin: 130px auto 216px;
        }

        .certificate-box .name {
            text-align: center;
            font-family: "Tangerine", cursive;
            font-size: 52px;
            font-weight: normal;
            word-spacing: 4px;
            margin-bottom: 7px;
        }

        .certificate-box .bottom-text {
            text-align: center;
            font-family: "Poppins", sans-serif;
            word-spacing: 2px;
            font-size: 12px;
            font-weight: normal;
            margin-top: 0;
        }

        .bottom-text p {
            margin: 4px 0;
        }

        .course-title {
            font-size: 15px;
            font-weight: 600;
            margin: 0 !important;
        }

        .course-type {
            font-weight: normal;
        }

        .company-name {
            font-size: 13px;
        }

        .branch-name {
            font-size: 12px;
        }

        .signatures {
            width: 57.8% !important;
            text-align: center;
            word-spacing: 2px;
            font-size: 14px;
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
    </style>
</head>

<body>
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
            <span class="fs-6 course-type" style="margin-bottom: 0px !important;">The Online Course of </span>
            <p class="course-title">"{{ $enroll->vid_course->course_title }}"</p>
            <p class="company-name">
                From Pathway Driving Training School
            </p>
        </div>

        <div class="signatures">
            <div class="left">
                <div class="sign" style="position: absolute; bottom: 19.5%; left:  24%;">
                    <img src="{{ asset('uploads/signature/' . $manager_signature) }}" width="110" alt="" />
                </div>
                <div class="designation" style="position: absolute; bottom: 16.6%; left: 20.6%;">Signature of Branch Manager</div>
            </div>

            <div class="right">
                <div class="sign" style="position: absolute; bottom: 19.5%; right:  24%;">
                    <img src="{{ asset('uploads/signature/signature-1-64213ab0a18c5.png') }}" width="110" alt="" />
                </div>
                <div class="designation" style="position: absolute; bottom: 16.6%; right: 22.3%;">Signature of Chairman</div>
            </div>
        </div>
    </div>
</body>

</html>
