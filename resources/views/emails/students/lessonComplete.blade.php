@component('mail::message')
  Hi {{$student->profile->first_name}},
  <br>
  <p>
      You have completed '{{ $lesson->name }}' lesson successfully.
  </p>

  Regards,<br>
  {{ config('app.name') }}
@endcomponent
