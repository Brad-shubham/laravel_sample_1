@extends('layouts.app')

@section('pageTitle','Edit Test')

@section('content')

    <div class="container-fluid">
        <test-edit :test='@json($test)'
                   :lessons='@json($lessons)'
                   :questionType='@json($questionType)'
        ></test-edit>
    </div>
@endsection
