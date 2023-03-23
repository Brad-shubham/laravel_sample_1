@extends('layouts.app')

@section('pageTitle','Course Progress')

@section('content')

    <div class="container-fluid">
        <student-report :student='@json($student)'></student-report>
    </div>
@endsection
