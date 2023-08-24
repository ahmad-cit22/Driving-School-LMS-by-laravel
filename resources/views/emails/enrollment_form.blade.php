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
            Thanks for your course enrollment. Your enrollment form (PDF) is attached with this email.
        </p>
        <div style="display: flex; justify-content: center;"><a href="{{ route('login') }}" style="background: #e87918eb; padding: 6px 10px; margin-top: 15px; margin-bottom: 15px; color: #fff; border-radius: 10px">Go to Dashboard</a></div>

        <p>Thanks <br> {{ env('APP_NAME') }}</p>
    </div>
</body>

</html>
