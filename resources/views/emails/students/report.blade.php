@component('mail::message')
  Hi {{$user->profile->first_name}},
  <br>
  <p>
    Here is the attached report of the students.
  </p>

  Regards,<br>
  {{ config('app.name') }}
@endcomponent
