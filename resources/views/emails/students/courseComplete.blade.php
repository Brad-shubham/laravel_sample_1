@component('mail::message')
  Hi {{$student->profile->first_name}},
  <br>
  <p>
      You have completed '{{ $course->name }}' course successfully.
  </p>

  Regards,<br>
  {{ config('app.name') }}
@endcomponent
