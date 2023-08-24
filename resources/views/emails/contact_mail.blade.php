<x-mail::message>
Hello!<br>
A message was recieved from a visitor. The details are below:

<x-mail::panel>
### Message Info:
Name: **{{ $data['name'] }}**<br>
Email: {{ $data['email'] }}<br>
Mobile No.: {{ $data['number'] }}<br>
Subject: **{{ $data['subject'] }}**<br>
Message Body: <br>{{ $data['message'] }}<br>
</x-mail::panel>

<x-mail::button :url="route('login')">
Go to Dashboard
</x-mail::button>

</x-mail::message>