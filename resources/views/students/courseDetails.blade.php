@extends('layouts.app')

@section('pageTitle','Course Details')

@section('content')

    <div class="container-fluid">
        <student-course-detail :student='@json($student)'
                               :course='@json($course)'
        ></student-course-detail>
    </div>
@endsection
