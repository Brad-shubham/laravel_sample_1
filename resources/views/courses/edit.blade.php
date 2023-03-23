@extends('layouts.app')

@section('pageTitle','Edit Course')

@section('content')
    <div class="container-fluid">
        <course-edit :course='@json($course)'></course-edit>
    </div>

@endsection
