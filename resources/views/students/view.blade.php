@extends('layouts.app')

@section('pageTitle','View Student')

@section('content')

    <div class="container-fluid">
        <student-view :student='@json($student)'
                      :genders='@json($userGender)'
                      :martialStatus='@json($userMartialStatus)'
                      :userReligions='@json($userReligion)'
                      :userActivityStatus='@json($userActivityStatus)'
        ></student-view>
    </div>
@endsection
