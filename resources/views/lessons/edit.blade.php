@extends('layouts.app')

@section('pageTitle','Edit Lesson')

@section('content')
    <div class="container-fluid">
        <lesson-edit :lesson='@json($lesson)' :books='@json($books)'></lesson-edit>
    </div>

@endsection
