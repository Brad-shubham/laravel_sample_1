@extends('layouts.app')

@section('pageTitle','Edit Profile')

@section('content')

    <div class="container-fluid">
        <user-edit-profile :user='@json($user)'></user-edit-profile>
    </div>
@endsection
