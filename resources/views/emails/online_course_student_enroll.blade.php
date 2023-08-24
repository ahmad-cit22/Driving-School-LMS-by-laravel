<x-mail::message>
Hello **{{ $data['user']->name }}**,<br>
Thanks for your enrollment in our online course. You will be notified shortly after your enrollment gets approved. After approval, you can watch the class videos from your dashboard.

<x-mail::panel>
### Course Details:
Course Title: {{ $data['enroll']->vid_course->course_title }}<br>
Course Category: {{ $data['enroll']->vid_course->rel_to_course_cat->category_name }}<br>
Course Fee: Free<br>
</x-mail::panel>

<x-mail::button :url="route('login')">
Go to Dashboard
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>