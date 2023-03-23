@extends('layouts.app')

@section('pageTitle', 'Add New Lesson')

@section('content')

    <div class="container-fluid">
        <lesson-create :books='@json($books)'></lesson-create>
    </div>

@endsection
