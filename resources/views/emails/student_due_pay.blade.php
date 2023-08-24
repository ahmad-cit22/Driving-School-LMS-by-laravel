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
            Thanks for your payment. You will be notified when your enrollment gets approved. The invoice (PDF) is attached with this email.
        </p>
        <div style="background: #eee; padding: 8px 13px; border-radius: 10px; margin: 15px 0;">
            <p><b>Course Details:</b></p>
            <p>
                <b>Branch:</b> {{ $enroll->branch->branch_name }}<br>
                <b>Course Category:</b> {{ $enroll->category->category_name }}<br>
                <b>Course Type:</b> {{ $enroll->type->type_name }}<br>
                <b>Total Payable Fee:</b> BDT {{ number_format($enroll->payable_amount) }}<br>
                <b>Previously Paid:</b> BDT {{ number_format($previous_paid) }}<br>
                <b>Previous Due:</b> BDT {{ number_format($due) }}<br>
                <b>Now Paid:</b> BDT {{ $now_paid }}<br>
                <b>Current Due:</b> BDT {{ $enroll->payable_amount > $enroll->paid ? number_format($enroll->payable_amount - $enroll->paid) : '0' }}<br>
                <b>Payment Process:</b> {{ $enroll->payment_process == '1' ? 'Online Payment' : 'Office Payment' }}<br>
            </p>
        </div>
        <div style="display: flex; justify-content: center;"><a href="{{ route('login') }}" style="background: #e87918eb; padding: 6px 10px; margin-top: 15px; margin-bottom: 15px; color: #fff; border-radius: 10px">Go to Dashboard</a></div>

        <p>Thanks <br> {{ env('APP_NAME') }}</p>
    </div>
</body>

</html>
