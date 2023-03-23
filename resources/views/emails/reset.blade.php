@component('mail::message')
    Hi {{$details->profile->first_name}},
    <br>
    <p>
        Your OTP for password reset is - {{ $otp }}
    </p>

    Regards,
    {{ config('app.name') }}
@endcomponent
