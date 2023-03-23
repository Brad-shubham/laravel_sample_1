@extends('layouts.app')

@section('pageTitle','View Book')

@section('content')

    <div class="container-fluid">
        <book-view :book='@json($book)' :courses='@json($courses)'></book-view>
    </div>
@endsection
