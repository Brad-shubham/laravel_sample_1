@component('mail::message')
    Hi,
    <br>
    <p>
        Student {{ $student->profile->first_name }}  {{ $student->profile->surname }} has submitted the test {{ $test->title }} .
    </p>

    Regards,
    {{ config('app.name') }}
@endcomponent
