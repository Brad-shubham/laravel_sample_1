@extends('layouts.app')

@section('pageTitle','Edit Student')

@section('content')

    <div class="container-fluid">
        <student-edit :student='@json($student)'
                      :genders='@json($userGender)'
                      :martialStatus='@json($userMartialStatus)'
                      :userReligions='@json($userReligion)'
                      :userActivityStatus='@json($userActivityStatus)'
                      :postalCodes='@json($postalCodes)'
                      :countries='@json($countries)'
                      :languages='@json($languages)'
        >
        </student-edit>
    </div>
@endsection
