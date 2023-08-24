<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card</title>
    <style>
        @font-face {
            font-family: 'Open Sans';
            src: url({{ storage_path('fonts/Poppins-Regular.ttf') }}) format("truetype");
            font-weight: 400;
            font-style: normal;
        }
    </style>
</head>

<body style="margin: 0 auto;">
    <div style="padding: 50px; display: flex; flex-direction: column; align-items: center; gap: 10px;">
        <div style="width: 325px; height: 205px; border: 1px solid #2e3192; overflow: hidden; box-sizing: border-box;">
            <div style="box-sizing: border-box;">
                <div style="height: 60px; text-align: center; padding: 10px 0 3px 0; box-sizing: border-box;"><img style="height: 100%;" src="{{ asset("uploads/logos/$settings->logo_dark") }}"></div>
                <div style="font-family: Poppins; background-color: #2e3192; color: #fff; height: 25px; line-height: 25px; font-weight: 600; font-size: 15px; text-align: center; text-transform: uppercase; box-sizing: border-box;">Identity Card</div>
            </div>
            <div style="display: flex; gap: 10px; padding: 5px 10px; box-sizing: border-box; height: 95px; width: 100%">
                <div style="display: flex; align-items: center; box-sizing: border-box;"><img style="height: 75px;" src="{{ asset('uploads/users/' . $enroll->user->image) }}"></div>
                <div style="position: relative; box-sizing: border-box; width: 100%; padding-top: 5px">
                    <img src="{{ asset('uploads/logos/ic-card-bg-watermark.png') }}" style="position: absolute; width: 70px; opacity: 0.15; z-index: 0; top: 5px; right: 25px;">
                    <div style="display: flex; gap: 5px;">
                        <div>
                            <p style="font-size: 12px; padding: 0; margin: 0;">Name</p>
                            <p style="font-size: 12px; padding: 0; margin: 0;">Student ID</p>
                            <p style="font-size: 12px; padding: 0; margin: 0;">Mobile No</p>
                        </div>
                        <div>
                            <p style="font-size: 12px; padding: 0; margin: 0;">:</p>
                            <p style="font-size: 12px; padding: 0; margin: 0;">:</p>
                            <p style="font-size: 12px; padding: 0; margin: 0;">:</p>
                        </div>
                        <div>
                            <p style="font-size: 12px; padding: 0; margin: 0;">{{ $enroll->user->name }}</p>
                            <p style="font-size: 12px; padding: 0; margin: 0;">{{ $enroll->user->id_no }}</p>
                            <p style="font-size: 12px; padding: 0; margin: 0;">{{ $enroll->user->mobile }}</p>
                        </div>
                    </div>
                    <div style="background-color: #2e3192; color: #fff; width: 120px; padding: 3px 5px; line-height: 1; text-align: center; ">
                        <p style="font-size: 11px; font-weight: 500; padding: 0; margin: 0;">{{ $enroll->category->category_name }}</p>
                        <p style="font-size: 10px; font-weight: 300; padding: 0; margin: 0;">{{ $enroll->type->type_name }}</p>
                    </div>
                    <div class="signature"><img style="position: absolute; width: 70px; height: 20px; object-fit: cover; z-index: 1; bottom: 2px; right: 0px;" src="{{ asset('uploads/signature/' . $enroll->branch->branch_manager_signature) }}"></div>
                </div>
            </div>
            <div style="background-color: #2e3192; color: #fff; font-size: 11px; font-weight: 300; display: flex; height: 25px; padding: 0 10px; justify-content: space-between; align-items: center;">
                <p style="margin: 0; display: flex; gap: 5px;"><img style="height: 13px; width: 13px;" src="{{ asset('uploads/images/icons/web-globe.svg') }}"> {{ $url }}</p>
                <p style="margin: 0;">Branch Manager</p>
            </div>
        </div>
        <div style="width: 325px; height: 205px; border: 1px solid #2e3192; overflow: hid den; box-sizing: border-box; padding-top: 15px;">
            <div style="text-align: center; box-sizing: border-box;"><span style="background-color: #2e3192; color: #fff; font-weight: 600; padding: 5px 10px; text-transform: uppercase; font-size: 14px; box-sizing: border-box;">This Card is not transferable</span></div>
            <div style="display: flex; gap: 10px; padding: 20px; height: 135px; box-sizing: border-box;">
                <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; width: 30%;">
                    {!! QrCode::size(70)->generate(route('admin.students.id.verify', $uuid)) !!}
                    <p style="font-size: 10px; margin: 0;">Scan for verify</p>
                </div>
                <div class="divider">
                    <p style="width: 2px; height: 100%; background-color: #2e3192; margin: 0;"></p>
                </div>
                <div style="position: relative; width: 70%; display: flex; flex-direction: column; justify-content: center;">
                    <img src="{{ asset('uploads/logos/ic-card-bg-watermark.png') }}" style=" position: absolute; width: 70px; opacity: 0.15; z-index: 0; top: 20px; right: 20px;">
                    <div style="display: flex; flex-direction: column; justify-content: center; width: 100%; font-size: 10px;">
                        <p style="font-weight: 500; margin: 0;">Branch Address:</p>
                        <p style="margin: 0;">{{ $enroll->branch->branch_address }}</p>
                        <p style="font-weight: 500; margin: 0;">Head Office:</p>
                        <p style="margin: 0;">{{ $settings->head_office }}</p>
                        <p style="margin: 0;"><span style="font-weight: 500;">Website:</span> {{ $url }}</p>
                    </div>
                </div>
            </div>
            <div style="font-size: 14px; line-height: 30px; text-align: center; color: #fff; background-color: #2e3192;">Date of Expiry: {{ $enroll->start_date->addDay($enroll->type->max_duration >= 30 ? $enroll->type->max_duration : 30)->format('d-m-Y') }}</div>
        </div>
    </div>
</body>

</html>
