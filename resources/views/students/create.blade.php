@extends('layouts.app')

@section('pageTitle','Create Student')

@section('content')

    <div class="container-fluid">
        <student-create :genders='@json($userGender)'
                        :martialStatus='@json($userMartialStatus)'
                        :userReligions='@json($userReligion)'
                        :userActivityStatus='@json($userActivityStatus)'
                        :postalCodes='@json($postalCodes)'
                        :countries='@json($countries)'
                        :languages='@json($languages)'
        ></student-create>
    </div>
@endsection
