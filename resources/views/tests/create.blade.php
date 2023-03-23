@extends('layouts.app')

@section('pageTitle','Add Test')

@section('content')

    <div class="container-fluid">
        <test-create :lessons='@json($lessons)'
                     :questionType='@json($questionType)'
        ></test-create>
    </div>
@endsection
