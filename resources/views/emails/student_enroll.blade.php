<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
    <div class="email-body" style="padding: 10px 20px">
        <p>
            Hello <b>{{ $user->name }}!</b><br>
            Thanks for your course enrollment. You will be notified shortly after your enrollment gets approved. The invoice (PDF) is attached with this email.
        </p>
        <div style="background: #eee; padding: 8px 13px; border-radius: 10px; margin: 15px 0;">
            <p><b>Course Details:</b></p>
            <p>
                <b>Branch:</b> {{ $enroll->branch->branch_name }}<br>
                <b>Course Category:</b> {{ $enroll->category->category_name }}<br>
                <b>Course Type:</b> {{ $enroll->type->type_name }}<br>
                <b>Course Fee:</b> BDT {{ number_format($enroll->price) }}<br>
                <b>Discount:</b> BDT {{ number_format($enroll->discount) }}<br>
                <b>Payable Amount:</b> BDT {{ number_format($enroll->payable_amount) }}<br>
                <b>Payment Process:</b> {{ $enroll->payment_process == '1' ? 'Online Payment' : 'Office Payment' }}<br>
                @if ($enroll->payment_process == '1')
                    <b>Paid Amount:</b> BDT {{ $enroll->paid }}<br>
                    <b>Due:</b> BDT {{ $enroll->payable_amount > $enroll->paid ? number_format($enroll->payable_amount - $enroll->paid) : 'None.' }}<br>
                @else
                    <b>Due:</b> BDT {{ number_format($enroll->payable_amount) }} (Please pay it as soon as possible to get your enrollment approved.)<br>
                @endif
                <b>Start Date:</b> {{ Carbon\Carbon::parse($enroll->start_date)->format('d-m-Y') }}<br>
                <b>Time Schedule:</b> {{ Carbon\Carbon::parse($enroll->slot->start_time)->format('h:ia') }} - {{ Carbon\Carbon::parse($enroll->slot->end_time)->format('h:ia') }}<br>
            </p>
        </div>
        <div style="display: flex; justify-content: center;"><a href="{{ route('login') }}" style="background: #e87918eb; padding: 6px 10px; margin-top: 15px; margin-bottom: 15px; color: #fff; border-radius: 10px">Go to Dashboard</a></div>

        <p>Thanks <br> {{ env('APP_NAME') }}</p>
    </div>
</body>

</html>
