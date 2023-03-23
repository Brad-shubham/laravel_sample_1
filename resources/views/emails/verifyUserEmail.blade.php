@component('mail::message')
  Hi {{$user->profile->first_name}},
  <br>
  <p>
    Your registered Email ID: {{$user->email}} , Please click on the below link to verify your email account.
  </p>
  <br>

  @component('mail::button', ['url' => $verificationUrl])
    Verify Email
  @endcomponent
  <br>

  Regards,<br>
  {{ config('app.name') }}
@endcomponent
