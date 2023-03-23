@extends('layouts.app')

@section('pageTitle','Edit Book')

@section('content')
    <div class="container-fluid">
        <book-edit :book='@json($book)' :courses='@json($courses)'></book-edit>
    </div>

@endsection
