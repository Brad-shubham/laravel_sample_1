@extends('layouts.app')

@section('pageTitle','View Course')

@section('content')

    <div class="container-fluid">
        <course-view :course='@json($course)'></course-view>
    </div>
@endsection
