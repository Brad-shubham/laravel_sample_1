@extends('layouts.app')

@section('pageTitle','View Test')

@section('content')

    <div class="container-fluid">
        <test-view :test='@json($test)'
                   :questionType='@json($questionType)'
        ></test-view>
    </div>
@endsection
