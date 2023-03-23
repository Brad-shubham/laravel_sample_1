@extends('layouts.app')

@section('pageTitle', 'Add New Book')

@section('content')

    <div class="container-fluid">
        <book-create :courses='@json($courses)'></book-create>
    </div>

@endsection
