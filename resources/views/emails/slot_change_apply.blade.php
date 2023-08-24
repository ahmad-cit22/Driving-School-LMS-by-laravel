<x-mail::message>
Hello **Branch Manager**,<br>
A student applied for changing their course slot. Please take proper steps. 

<x-mail::panel>
### Application Details:
Student Name: {{ $data['user']->name }}<br>
Course Category: {{ $data['enroll']->category->category_name }}<br>
Course Type: {{ $data['enroll']->type->type_name }}<br>
Course Status: 
@if ($data['enroll']->status == 1)
    Approved<br>
@elseif ($data['enroll']->status == 2)
    Finished<br>
@else
    Not Approved<br>
@endif

Payment Status: 
@if ($data['enroll']->payment_status == 1)
    Has Due<br>
@elseif ($data['enroll']->payment_status == 2)
    Completed<br>
@else
    Not Paid<br>
@endif

Current Course Slot: {{ Carbon\Carbon::parse($data['enroll']->slot->start_time)->format('h:ia') }} - {{ Carbon\Carbon::parse($data['enroll']->slot->end_time)->format('h:ia') }}<br>
Requested Course Slot: {{ $data['slot'] }}<br>
</x-mail::panel>

<x-mail::button :url="route('admin.enroll.show', $data['enroll']->id)">
View Enrollment
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>