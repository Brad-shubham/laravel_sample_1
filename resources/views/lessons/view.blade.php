@extends('layouts.app')

@section('pageTitle','View Lesson')

@section('content')

    <div class="container-fluid">
        <lesson-view :lesson='@json($lesson)' :books='@json($books)'></lesson-view>
    </div>
@endsection
