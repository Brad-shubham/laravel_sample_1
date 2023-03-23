@extends('layouts.app')

@section('pageTitle','Create User')

@section('content')

    <div class="container-fluid">
        <user-create :userRoles='@json($userRoles)'
                     :postalCodes='@json($postalCodes)'
                     :countries='@json($countries)'>
        </user-create>
    </div>
@endsection
