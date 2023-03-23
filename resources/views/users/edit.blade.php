@extends('layouts.app')

@section('pageTitle','User Edit')

@section('content')

    <div class="container-fluid">
        <user-edit :user='@json($user)'
                   :userRoles='@json($userRoles)'
                   :postalCodes='@json($postalCodes)'
                   :countries='@json($countries)'>
        </user-edit>
    </div>
@endsection
