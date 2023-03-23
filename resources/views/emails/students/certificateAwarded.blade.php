@component('mail::message')
  Hi {{$student->profile->first_name}},
  <br>
  <p>
      You have assigned "LEVEL {{ $certificate->level }}" certificate.
  </p>

  @component('mail::button', ['url' => $downloadUrl])
    Download Certificate
  @endcomponent
  <br>

  Regards,<br>
  {{ config('app.name') }}
@endcomponent
