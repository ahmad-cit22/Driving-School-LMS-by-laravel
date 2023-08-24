<x-mail::message>
Hello **{{ $data['user']->name }}**,<br>
Thanks for your course enrollment. You will be notified shortly after your enrollment gets approved.

<x-mail::panel>
### Course Details:
Branch: {{ $data['enroll']->branch->branch_name }}<br>
Course Category: {{ $data['enroll']->category->category_name }}<br>
Course Type: {{ $data['enroll']->type->type_name }}<br>
Course Fee: BDT {{ $data['enroll']->price }}<br>
Payment Process: {{ $data['enroll']->payment_process == '1' ? 'Online' : 'Offline' }}<br>
@if ($data['enroll']->payment_process == '1')
    Paid Amount: BDT {{ $data['enroll']->paid }}<br>
    Due: BDT {{ $data['enroll']->price > $data['enroll']->paid ? $data['enroll']->price - $data['enroll']->paid : 'None.' }}<br>
@else
    Due: BDT {{ $data['enroll']->price }} (Please pay it as soon as possible to get your enrollment approved.)<br>
@endif
Start Date: {{ Carbon\Carbon::parse($data['enroll']->start_date)->format('d-m-Y') }}<br>
Time Schedule: {{ Carbon\Carbon::parse($data['enroll']->slot->start_time)->format('h:ia') }} - {{ Carbon\Carbon::parse($data['enroll']->slot->end_time)->format('h:ia') }}<br>
</x-mail::panel>

<x-mail::button :url="route('admin.enroll_invoice.generate', $data['enroll']->id)">
Download Invoice
</x-mail::button>
<x-mail::button :url="route('login')">
Go to Dashboard
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>