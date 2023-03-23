@extends('layouts.app')

@section('pageTitle','User View')

@section('content')

    <div class="container-fluid">
        <user-view :user='@json($user)'></user-view>
    </div>
@endsection
