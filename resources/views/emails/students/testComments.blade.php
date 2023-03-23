@component('mail::message')
  Hi {{$student->profile->first_name}},
  <br>
  <p>
      There are some feedbacks from teacher on {{ $test->title }} test.
  </p>

  Regards,<br>
  {{ config('app.name') }}
@endcomponent
