@extends('layouts.app')

@section('pageTitle','Edit Test Result')

@section('content')

    <div class="container-fluid">
        <test-result-edit :testResult='@json($testAnswer)'
                          :questionType='@json(\App\Models\TestQuestion::QUESTION_TYPE)'
                          :maxMarks='@json(\App\Models\TestQuestion::MAX_MARKS)'
                          :status='@json(\App\Models\TestResult::STATUS)'
        ></test-result-edit>
    </div>
@endsection
