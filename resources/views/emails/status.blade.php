@extends('layouts.auth')

@section('content')
    <div class="jumbotron tb-auth-container">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="text-center align-items-center">
                    <div class="logo pb-5">
                        <img src="{{ asset('images/logo-blue.png') }}">
                    </div>
                    <div class="message pt-5 text-gray-900">
                        <p class="lead"><strong>{{$status}}</strong></p>
                        <hr>
                        <p>Having trouble? <a href="#">Contact us</a></p>
                    </div>
                </div>
            </div>
        </div>
@endsection
