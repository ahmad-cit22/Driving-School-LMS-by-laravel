<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card</title>
    <link href="{{ asset('assets/backend/css/id-card.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="card-front">
            <div class="header">
                <div class="logo"><img src="{{ asset("uploads/logos/$settings->logo_dark") }}"></div>
                <div class="title">Identity Card</div>
            </div>
            <div class="content">
                <table>
                    <tr>
                        <td width="70px">
                            <div class="image"><img src="{{ asset('uploads/users/' . $enroll->user->image) }}"></div>
                        </td>
                        <td>
                            <div class="details">
                                <img src="{{ asset('uploads/logos/ic-card-bg-watermark.png') }}" class="watermark">
                                <table>
                                    <tr>
                                        <td width="60px">Name</td>
                                        <td width="0px">:</td>
                                        <td>{{ $enroll->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Student ID</td>
                                        <td>:</td>
                                        <td>{{ $enroll->user->id_no }}</td>
                                    </tr>
                                    <tr>
                                        <td>Mobile No</td>
                                        <td>:</td>
                                        <td>{{ $enroll->user->mobile }}</td>
                                    </tr>

                                </table>
                                <div class="course">
                                    <p>{{ $enroll->category->category_name }}</p>
                                    <p>{{ $enroll->type->type_name }}</p>
                                </div>
                                <div class="signature"><img src="{{ asset('uploads/signature/' . $enroll->branch->branch_manager_signature) }}"></div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="footer">
                <table>
                    <tr>
                        <td>{{ $url }}</td>
                        <td style="text-align: right">Branch Manager</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="card-back">
            <div class="title"><span>This Card is not transferable</span></div>
            <div class="content">
                <table>
                    {!! QrCode::size(70)->generate(route('admin.students.id.verify', $uuid)) !!}
                    <tr>
                        <td width="70px">
                            <div class="verification">
                                <img src="data:image/png;base64, {!! base64_encode(
                                    QrCode::format('svg')->size(70)->errorCorrection('H')->generate(route('admin.students.id.verify', $uuid)),
                                ) !!}">
                                <p>Scan for verify</p>
                            </div>
                        </td>
                        <td>
                            <div class="divider">
                                <p></p>
                            </div>
                        </td>
                        <td>
                            <div class="details">
                                <img src="{{ asset('uploads/logos/ic-card-bg-watermark.png') }}" class="watermark">
                                <div class="branch-data">
                                    <p class="bold">Branch Address:</p>
                                    <p>{{ $enroll->branch->branch_address }}</p>
                                    <p class="bold">Head Office:</p>
                                    <p>{{ $settings->head_office }}</p>
                                    <p><span class="bold">Website:</span> {{ $url }}</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="footer">Date of Expiry: {{ $enroll->start_date->addDay($enroll->type->max_duration >= 30 ? $enroll->type->max_duration : 30)->format('d-m-Y') }}</div>
        </div>
    </div>
</body>

</html>
