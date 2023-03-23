@extends('layouts.app')

@section('pageTitle','Offline Test Entries')

@section('content')

    <div class="container-fluid">
        <offline-test-entry :tests='@json($tests)'
                   :students='@json($students)'
        ></offline-test-entry>
    </div>
@endsection
