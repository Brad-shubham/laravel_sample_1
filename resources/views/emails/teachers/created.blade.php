@component('mail::message')
  Hi {{$student->profile->first_name}},
  <br>
  <p>
    You are invited to Truth Bible app. Here is your credentials to login into the system.
  </p>

  <p>
      Email - {{ $student->email }}<br>
      Password - {{ $password }}<br>
  </p>

  @component('mail::button', ['url' => $actionUrl])
      Click Here
  @endcomponent

  Regards,<br>
  {{ config('app.name') }}
@endcomponent
