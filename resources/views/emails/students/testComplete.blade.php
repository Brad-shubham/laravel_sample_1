@component('mail::message')
  Hi {{$student->profile->first_name}},
  <br>
  <p>
      {{ $message }}
  </p>

  Regards,<br>
  {{ config('app.name') }}
@endcomponent
