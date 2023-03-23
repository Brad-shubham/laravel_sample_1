@component('mail::message')
  Hi {{$student->profile->first_name}},
  <br>
  <p>
    You are invited to Truth Bible app. Here is your credentials to login into the system.
  </p>

  <p>
      Email - {{ $student->email }}<br>
      Student ID - {{ $student->student_id }}<br>
      Password - {{ $password }}<br>
  </p>

  Regards,<br>
  {{ config('app.name') }}
@endcomponent
